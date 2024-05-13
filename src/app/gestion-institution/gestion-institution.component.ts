import { Component ,OnInit } from '@angular/core';
import { InstitutionService } from '../services/institution.service';
import { Observable } from 'rxjs';
import { Institution } from '../models/institution.model';



declare const bootstrap: any;
@Component({
  selector: 'app-gestion-institution',
  templateUrl: './gestion-institution.component.html',
  styleUrl: './gestion-institution.component.css'
})
export class GestionInstitutionComponent  implements OnInit{
  selectedInstitution!: Institution; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  institutions!: Observable<Institution[]>;
  institutions2!: Observable<Institution[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};
  showAddInstitutionForm: boolean = false;
  showUpdateInstitutionForm :boolean = false;

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';

// instancier une new obj institution pour les ajout  et modif
institution: Institution = {
  id_institution: -1,
  nom: '',
  logo: '',
  id_adresse: -1,
};
//maj de instit 
InstitutionToUpdate: Institution | null = null;


  
  constructor(private institutionService:InstitutionService) { }

  ngOnInit(): void {
    this.loadInstitutions();
  }

  loadInstitutions() {
  this.institutions = this.institutionService.getInstitutions(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  

  toggleAddInstitutionForm(): void {
    if (this.showAddInstitutionForm || this.showUpdateInstitutionForm) {
      this.showAddInstitutionForm = false;
      this.showUpdateInstitutionForm = false;
    } else {
      this.showAddInstitutionForm = true;
    }
  }

  toggleUpdateInstitutionForm(institution: Institution) {
    this.InstitutionToUpdate = institution;
    this.showUpdateInstitutionForm = true;
    this.showAddInstitutionForm = false; // Assurez-vous que le formulaire d'ajout est masqué
  }


  nextPage() {
    this.currentPage++;
   // console.log('Current Page:', this.currentPage);
    this.loadInstitutions();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
    //  console.log('Current Page:', this.currentPage);
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
            this.loadInstitutions();
           this.showSuccessToast('Aucune institution trouvé pour ce nom ');
           
          }
        }, 
        (error) => {
          console.error('Error updating institution:', error);
          this.showErrorToast('Erreur lors de la modification de l\'institution.');
        }
      );
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadInstitutions();
    }
  }
  

 


    updateInstitution(InstitutionToUpdate: Institution) {
      this.institutionService.updateInstitution(InstitutionToUpdate).subscribe(
        () => {
          this.loadInstitutions();
          this.showSuccessToast('Institution modifiée avec succès.');
         // this.InstitutionToUpdate = null;
        },
        (error) => {
          console.error('Error updating institution:', error);
          this.showErrorToast('Erreur lors de la modification de l\'institution.');
        }
      );
    }

 
  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addInstitution(institution: Institution) {
    this.institutionService.addInstitution(institution).subscribe(
      () => {
        this.institution.logo = ''; 
        this.loadInstitutions();
        this.showSuccessToast('Institution ajoutée avec succès.');
        
       
      },
      (error) => {
        console.error('Error adding institution:', error);
        this.showErrorToast('Erreur lors de l\'ajout de l\'institution.');
        this.loadInstitutions();
      }
    );
    
    
  }



  
 deleteInstitution(institutionId: number) {
  this.institutionService.deleteInstitution(institutionId).subscribe(
    () => {
      this.loadInstitutions();
      this.showSuccessToast('Institution supprimée avec succès.');
    },
    (error) => {
      console.error('Error deleting institution:', error);
      this.showErrorToast('Erreur lors de la suppression de l\'institution.');
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


  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSuccessa');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErrora');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }

}
