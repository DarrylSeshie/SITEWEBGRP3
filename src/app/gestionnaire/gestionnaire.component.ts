import { Component, OnInit   } from '@angular/core';
import { UserService } from '../services/user.service'; // import des services (mehode) et model
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';



declare const bootstrap: any;
@Component({
  selector: 'app-gestion-utilisateur',
  templateUrl: './gestionnaire.component.html',
  styleUrl: './gestionnaire.component.css'
})
export class GestionnaireComponent implements OnInit{

  selectedUser!: User; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 20;
  users!: Observable<User[]>;
  users2!: Observable<User[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};
  showAddUserForm: boolean = false;
  showUpdateUserForm :boolean = false;

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';

  

  UserToUpdate: User | null = null;
  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
  //  this.users = this.userService.getUsers();
  this.users = this.userService.getUsers(this.currentPage, this.pageSize);
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
    //  console.log('Current Page:', this.currentPage);
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
            const toastElement = document.getElementById('liveToastSuccess');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucun utilisateur trouvé pour ce nom ';
            this.errorMessage = ''; 
           
          }
        },
        (error) => {
          const toastElement = document.getElementById('liveToastError');
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

  


  
  updateUser(UserToUpdate: User) {
    this.userService.updateRole(UserToUpdate).subscribe(
      () => {
        this.loadUsers();
        this.showSuccessToast('client modifiée avec succès.'); 
        
      },
      error => {
       
        console.error('Error updating user:', error);
        this.showErrorToast('Erreur lors de la modification du client.');
      
      }
    );
    
  }


  selectUser(userId: number) {
    this.userService.getUserById(userId).subscribe(
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
    const toastElement = document.getElementById('liveToastSuccess');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastError');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }


}
