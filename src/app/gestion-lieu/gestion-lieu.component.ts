import { Component, OnInit } from '@angular/core';
import { Lieu } from '../models/lieu.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { LieuService } from '../services/lieu.service';

declare const bootstrap: any;
@Component({
  selector: 'app-gestion-lieu',
  templateUrl: './gestion-lieu.component.html',
  styleUrl: './gestion-lieu.component.css'
})
export class GestionLieuComponent {


  
  selectedLieu!: Lieu; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  lieux!: Observable<Lieu[]>;
  lieux2!: Observable<Lieu[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};
  
  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';


  constructor(private lieuService: LieuService) { }

  ngOnInit(): void {
    this.loadLieux();
  }

  loadLieux() {
  this.lieux = this.lieuService.getLieux(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadLieux();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadLieux();
    }
  }

  toggleDetails(lieu: Lieu) {
    const lieuId = lieu.id_lieu;
    if (this.userDetailVisible[lieuId]) {
      this.userDetailVisible[lieuId] = false;
    } else {
      this.userDetailVisible[lieuId] = true;
    }
  }

  searchLieuByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.lieux2 = this.lieuService.searchLieuxByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.lieux2.subscribe(
        (users) => {
          if (users.length === 0) {
            const toastElement = document.getElementById('liveToast');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucun utilisateur trouvé pour ce nom ';
            this.errorMessage = ''; 
           
          }
        },
        (error) => {
          const toastElement = document.getElementById('liveToast');
          const toastBootstrap = new bootstrap.Toast(toastElement);
          toastBootstrap.show();
          console.error('Error search user:', error);
          this.errorMessage = 'Erreur de recherche , vous avez mal encodez  ';
          this.successMessage = '';
        }
      );
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadLieux();
    }
  }
  

  deleteLieu(lieuId: number) {
    // Appel du service pour supprimer l'utilisateur
    this.lieuService.deleteLieu(lieuId).subscribe(
      () => {
        this.loadLieux(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Lieu supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression de lieu car celui ci est affilié à un evenement  ';
        this.successMessage = '';
      }
    );
  }

  updateLieu(lieu: Lieu) {
    this.lieuService.updateLieu(lieu).subscribe(
      () => {
        this.loadLieux(); // Recharger la liste des utilisateurs après la mise à jour
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Lieu modifié avec succès.';
        this.errorMessage = ''; // Réinitialiser le message d'erreur
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error updating user:', error);
        this.errorMessage = 'Erreur lors de la modification de lieu : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addLieu(lieu: Lieu) {
    this.lieuService.addLieu(lieu).subscribe(
      () => {
        this.loadLieux(); // Recharger la liste des utilisateurs après ajout
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Lieu ajouté avec succès.';
        this.errorMessage = ''; 
       
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error adding user:', error);
        this.errorMessage = 'Erreur lors de l\'ajout de lieu : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }

  selectLieu(lieuId: number) {
    this.lieuService.getLieuById(lieuId).subscribe(
      lieu => {
        this.selectedLieu = lieu;
        // Toggle the visibility of user details
        this.toggleDetails(lieu);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }

}
