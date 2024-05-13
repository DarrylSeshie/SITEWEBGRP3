import { Component, OnInit } from '@angular/core';
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { FormateurService } from '../services/formateur.service';


declare const bootstrap: any;
@Component({
  selector: 'app-gestion-formateur',
  templateUrl: './gestion-formateur.component.html',
  styleUrl: './gestion-formateur.component.css'
})
export class GestionFormateurComponent {


  
  selectedUser!: User; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  formateurs!: Observable<User[]>;
  formateurs2!: Observable<User[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};
  showAddUserForm: boolean = false;
  showUpdateUserForm :boolean = false;


   // message de notifs
   successMessage: string = '';
   errorMessage: string = '';
 


   
  user: User = {
    id_utilisateur: -1, 
    civilite: '',        
    nom: '',             
    prenom: '',          
    email: '',           
    mot_de_passe: '',    
    gsm: '',             
    TVA: 'VIDE',            
    profession: '',     
    gsm_pro: 'VIDE',        
    email_pro: 'VIDE',      
    id_role: 3,         
    id_institution: -1,  
    id_adresse: -1
  };

  UserToUpdate: User | null = null;
  constructor(private formateurService: FormateurService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
  //  this.users = this.formateurService.getUsers();
  this.formateurs = this.formateurService.getUsers(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }


   
  toggleAddUserForm(): void {
    if (this.showAddUserForm || this.showUpdateUserForm) {
      this.showAddUserForm = false;
      this.showUpdateUserForm = false;
    } else {
      this.showAddUserForm = true;
    }
  }

  toggleUpdateUserForm(User: User) {
    this.UserToUpdate = User;
    this.showUpdateUserForm = true;
    this.showAddUserForm = false; // Assurez-vous que le formulaire d'ajout est masqué
  }
  
  nextPage() {
    this.currentPage++;
   // console.log('Current Page:', this.currentPage);
    this.loadUsers();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
     // console.log('Current Page:', this.currentPage);
      this.loadUsers();
    }
  }

  toggleDetails(user: User) {
    const userId = user.id_utilisateur;
    if (this.userDetailVisible[userId]) {
      this.userDetailVisible[userId] = false;
    } else {
      this.userDetailVisible[userId] = true;
    }
  }

  searchUsersByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.formateurs2 = this.formateurService.searchFormateursByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.formateurs2.subscribe(
        (formateurs) => {
          if (formateurs.length === 0) {
            const toastElement = document.getElementById('liveToastSucce');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucun utilisateur trouvé pour ce nom ';
            this.errorMessage = ''; 
           
          }
        },
        (error) => {
          const toastElement = document.getElementById('liveToastErrore');
          const toastBootstrap = new bootstrap.Toast(toastElement);
          toastBootstrap.show();
          console.error('Error search user:', error);
          this.errorMessage = 'Erreur de recherche , vous avez mal encodez  ';
          this.successMessage = '';
        }
      );
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadUsers();
    }
  }
  

  deleteUser(userId: number) {
    // Appel du service pour supprimer l'utilisateur
    this.formateurService.deleteFormateur(userId).subscribe(
      () => {
        this.loadUsers(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToastSucce');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Formateur supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToastErrore');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression du formateur car celui ci est affilié à un evenement  ';
        this.successMessage = '';
      }
    );
  }




  updateUser(user: User) {
    this.formateurService.updateFormateur(user).subscribe(
      () => {
        this.loadUsers();
        this.showSuccessToast('formateur modifiée avec succès.'); 
      },
      error => {
        console.error('Error updating user:', error);
        this.showErrorToast('Erreur lors de la modification du formateur.');
      }
    );
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur

  addUser(user: User) {
    this.formateurService.addFormateur(user).subscribe(
      () => {
        this.loadUsers(); // Recharger la liste des utilisateurs après ajout
        this.showSuccessToast('formateur ajoutée avec succès.');
       
      },
      error => {
        console.error('Error adding user:', error);
        this.showErrorToast('Erreur lors de l\'ajout du formateur');
      }
    );
  }


  selectUser(userId: number) {
    this.formateurService.getFormateurById(userId).subscribe(
      user => {
        this.selectedUser = user;
        // Toggle the visibility of user details
        this.toggleDetails(user);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }


  
  
  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSucce');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErrore');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }
}
