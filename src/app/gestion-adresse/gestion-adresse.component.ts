import { Component } from '@angular/core';
import { Adresse } from '../models/adresse.model';
import { Observable } from 'rxjs';
import { AdresseService } from '../services/adresse.service';


declare const bootstrap: any;
@Component({
  selector: 'app-gestion-adresse',
  templateUrl: './gestion-adresse.component.html',
  styleUrl: './gestion-adresse.component.css'
})
export class GestionAdresseComponent {

  
  selectedAdresse!: Adresse; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  Adresses!: Observable<Adresse[]>;
  Adresses2!: Observable<Adresse[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};


    // message de notifs
    successMessage: string = '';
    errorMessage: string = '';
  constructor(private adresseService:AdresseService) { }

  ngOnInit(): void {
    this.loadAdresses();
  }

  loadAdresses() {
  this.Adresses = this.adresseService.getAdresses(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadAdresses();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadAdresses();
    }
  }

  toggleDetails(adresse: Adresse) {
    const AdresseId = adresse.id_adresse;
    if (this.userDetailVisible[AdresseId]) {
      this.userDetailVisible[AdresseId] = false;
    } else {
      this.userDetailVisible[AdresseId] = true;
    }
  }

  searchAdresseByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.Adresses2 = this.adresseService.searchAdressesByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.Adresses2.subscribe(
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
      this.loadAdresses();
    }
  }
  

  deleteAdresse(adresseId: number) {
     // Appel du service pour supprimer l'utilisateur
     this.adresseService.deleteAdresse(adresseId).subscribe(
      () => {
        this.loadAdresses(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Adresse supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression de l\'adresse car celui ci est affilié à un evenement ou un client  ';
        this.successMessage = '';
      }
    );
  }

  updateAdresse(adresse: Adresse) {
  
    this.adresseService.updateAdresse(adresse).subscribe(
      () => {
        this.loadAdresses(); // Recharger la liste des utilisateurs après la mise à jour
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Adresse modifié avec succès.';
        this.errorMessage = ''; // Réinitialiser le message d'erreur
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error updating user:', error);
        this.errorMessage = 'Erreur lors de la modification de l\'adresse  : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addAdresse(adresse: Adresse) {
    this.adresseService.addAdresse(adresse).subscribe(
      () => {
        this.loadAdresses(); // Recharger la liste des utilisateurs après ajout
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Utilisateur ajouté avec succès.';
        this.errorMessage = ''; 
       
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error adding user:', error);
        this.errorMessage = 'Erreur lors de l\'ajout de l\'utilisateur : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }


  selectAdresse(lieuId: number) {
    this.adresseService.getAdresseById(lieuId).subscribe(
      lieu => {
        this.selectedAdresse = lieu;
        // Toggle the visibility of user details
        this.toggleDetails(lieu);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }
}
