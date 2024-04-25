import { Component, OnInit , ElementRef, ViewChild  } from '@angular/core';
import { UserService } from '../services/user.service'; // import des services (mehode) et model
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { Adresse } from '../models/adresse.model';
import { Institution } from '../models/institution.model';
import { Role } from '../models/role.model';


declare const bootstrap: any;
@Component({
  selector: 'app-gestion-utilisateur',
  templateUrl: './gestion-utilisateur.component.html',
  styleUrl: './gestion-utilisateur.component.css'
})
export class GestionUtilisateurComponent implements OnInit{

  selectedUser!: User; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  users!: Observable<User[]>;
  users2!: Observable<User[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';


  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
  //  this.users = this.userService.getUsers();
  this.users = this.userService.getUsers(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadUsers();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
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
      this.users2 = this.userService.searchUsersByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.users2.subscribe(
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
      this.loadUsers();
    }
  }

  

  deleteUser(userId: number) {
    // Appel du service pour supprimer l'utilisateur
    this.userService.deleteUser(userId).subscribe(
      () => {
        this.loadUsers(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Utilisateur supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression de l\'utilisateur car celui ci est affilié à un evenement  ';
        this.successMessage = '';
      }
    );
  }

  
  updateUser(user: User) {
    this.userService.updateUser(user).subscribe(
      () => {
        this.loadUsers(); // Recharger la liste des utilisateurs après la mise à jour
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Utilisateur modifié avec succès.';
        this.errorMessage = ''; // Réinitialiser le message d'erreur
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error updating user:', error);
        this.errorMessage = 'Erreur lors de la modification de l\'utilisateur : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
    
  }


  addUser(user: User) {
    this.userService.addUser(user).subscribe(
      () => {
        this.loadUsers(); // Recharger la liste des utilisateurs après ajout
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





  selectUser(userId: number) {
    this.userService.getUserById(userId).subscribe(
      user => {
        this.selectedUser = user;
        console.log('selectedUser:', this.selectedUser);
        // Toggle the visibility of user details
        this.toggleDetails(user);

      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }

  selectAdresseById(id_adresse: number) {
    this.userService.getAdresseById(id_adresse)
     
  }

  selectInstitById(id_institution: number) {
    this.userService.getInstitutionById(id_institution);
  }


  selectRoleById(id_role: number) {
    this.userService.getRoleById(id_role)
  }
  





 /* selectUser(userId: number) {
    this.userService.getUserById(userId).subscribe(
      user => {
        this.selectedUser = user;
        console.log('selectedUser:', this.selectedUser);
  
        // Affichage des détails d'adresse, d'institution ou de rôle
        if (this.selectedUser.adresse) {
          console.log('User Address:', this.selectedUser.adresse);
        }
  
        if (this.selectedUser.institution) {
          console.log('User Institution:', this.selectedUser.institution);
        }
  
        if (this.selectedUser.role) {
          console.log('User Role:', this.selectedUser.role);
        }
  
        // Toggle the visibility of user details
        this.toggleDetails(user);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }*/


}
