import { Component } from '@angular/core';
import { InstitutionService } from '../services/institution.service';
import { Observable } from 'rxjs';
import { Institution } from '../models/institution.model';


declare const bootstrap: any;
@Component({
  selector: 'app-gestion-institution',
  templateUrl: './gestion-institution.component.html',
  styleUrl: './gestion-institution.component.css'
})
export class GestionInstitutionComponent {

  
  selectedInstitution!: Institution; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  institutions!: Observable<Institution[]>;
  institutions2!: Observable<Institution[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';

  constructor(private institutionService:InstitutionService) { }

  ngOnInit(): void {
    this.loadInstitutions();
  }

  loadInstitutions() {
  this.institutions = this.institutionService.getInstitutions(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadInstitutions();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadInstitutions();
    }
  }

  toggleDetails(institution: Institution) {
    const institutionId = institution.id_institution;
    if (this.userDetailVisible[institutionId]) {
      this.userDetailVisible[institutionId] = false;
    } else {
      this.userDetailVisible[institutionId] = true;
    }
  }

  searchInstitutionByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.institutions2 = this.institutionService.searchInstitutionsByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.institutions2.subscribe(
        (users) => {
          if (users.length === 0) {
            const toastElement = document.getElementById('liveToast');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucune institution trouvé pour ce nom ';
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
      this.loadInstitutions();
    }
  }
  

  deleteInstitution(institutionId: number) {
      // Appel du service pour supprimer l'utilisateur
      this.institutionService.deleteInstitution(institutionId).subscribe(
        () => {
          this.loadInstitutions(); 
          // Afficher le toast de confirmation
          const toastElement = document.getElementById('liveToast');
          const toastBootstrap = new bootstrap.Toast(toastElement);
          toastBootstrap.show();
          this.successMessage = 'Institution supprimer avec succès.';
          this.errorMessage = ''; 
        },
        error => {
          const toastElement = document.getElementById('liveToast');
          const toastBootstrap = new bootstrap.Toast(toastElement);
          toastBootstrap.show();
          console.error('Error deleting user:', error);
          this.errorMessage = 'Erreur de suppression de l\'institution car celui ci est affilié à un evenement  ';
          this.successMessage = '';
        }
      );
  }

  updateInstitution(institution: Institution) {
    this.institutionService.updateInstitution(institution).subscribe(
      () => {
        this.loadInstitutions(); // Recharger la liste des utilisateurs après la mise à jour
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Institution modifié avec succès.';
        this.errorMessage = ''; // Réinitialiser le message d'erreur
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error updating user:', error);
        this.errorMessage = 'Erreur lors de la modification de l\'institution : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addInstitution(institution: Institution) {
    this.institutionService.addInstitution(institution).subscribe(
      () => {
        this.loadInstitutions(); // Recharger la liste des utilisateurs après ajout
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Institution ajouté avec succès.';
        this.errorMessage = ''; 
       
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error adding user:', error);
        this.errorMessage = 'Erreur lors de l\'ajout de l\'institution : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }

  selectInstitution(institutionId: number) {
    this.institutionService.getInstitutionById(institutionId).subscribe(
      institution => {
        this.selectedInstitution = institution;
        // Toggle the visibility of user details
        this.toggleDetails(institution);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }
}
