import { Component, OnInit,EventEmitter, Output   } from '@angular/core';
import { UserService } from '../services/user.service'; // import des services (mehode) et model
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { InstitutionService } from '../services/institution.service';
import { AdresseService } from '../services/adresse.service';
import { Institution } from '../models/institution.model';
import { RegistrationApiService } from '../services/registration-api.service';
import { Adresse } from '../models/adresse.model';



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
  showAddUserForm: boolean = false;
  showUpdateUserForm :boolean = false;
  totalUsers!: number;
  

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
    profession: '',
    id_role: 4,
    id_adresse: -1,
    id_institution: -1, 
    adresse: {
      id_adresse: -1,
      code_postal: 0,
      rue_numero: '',
      localite: '',
      pays: ''
    },
    email_pro: 'VIDE',   
    gsm_pro: '',
    giografie: 'VIDE',
    TVA: '',
    institution: {
      id_institution: -1,
      nom: '',
      logo: 'null',
      id_adresse: -1
      },
    role: undefined
  };
  institutions: Institution[] = [];
  adresses : Adresse[] = [];
  UserToUpdate: User | null = null;
  constructor(private userService: UserService,private service: RegistrationApiService,private institutionService: InstitutionService,private adresseService: AdresseService ) { }
  @Output() addUserEvent = new EventEmitter();

  ngOnInit(): void {
    this.loadUsers();
    this.loadCount();
    this.loadInstitutions();
    this.loadAdresses();

   
  }
  loadInstitutions(): void {
    this.institutionService.getInstitutions(1, 10).subscribe(
      (institutions) => {
        this.institutions = institutions;
      },
      (error) => {
        console.error('Error fetching institutions:', error);
      }
    );
  }

  loadAdresses(): void {
    this.adresseService.getAdresses(1, 10).subscribe(
      (adresses) => {
        this.adresses = adresses;
      },
      (error) => {
        console.error('Error fetching adresses:', error);
      }
    );
  }

  loadUsers() {
  //  this.users = this.userService.getUsers();
  this.users = this.userService.getUsers(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }
  saveUser() {
    const sub = this.service.saveUser(this.user).subscribe({
      next: (user) => {
        this.totalUsers ++ ;
        this.addUserEvent.emit(user);
        sub.unsubscribe();
        this.showSuccessToast('Inscription avec succès.');
        
      },
      error: (error) => {
        this.errorMessage = error.error.error;
        sub.unsubscribe();
        console.log('add User Error : ',error);
        this.showErrorToast('Erreur lors de l\'inscription');
      }
    });
  }


loadCount() {
  this.userService.getTotalUsersCount().subscribe(
    total => {
      this.totalUsers = total;
    },
    error => {
      console.error('Error fetching total users count:', error);
    }
  );
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
    const totalPages = Math.ceil(this.totalUsers / this.pageSize);
    if (this.currentPage < totalPages) {
      this.currentPage++;
      this.loadUsers();
    }
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
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
            const toastElement = document.getElementById('liveToastSucc');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucun utilisateur trouvé pour ce nom ';
            this.errorMessage = ''; 
           
          }
        },
        (error) => {
          const toastElement = document.getElementById('liveToastErr');
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
        this.totalUsers -- ;// retire 1 user et refresh
        this.loadUsers(); 
        this.showSuccessToast('client supprimer avec succès.'); 
        
      },
      error => {
       console.log('Delete User Error : ',error);
        this.showErrorToast('Erreur lors de la suppression du client; celui ci est affilié à un evenement');
      }
    );
  }

  
  updateUser(UserToUpdate: User) {
    this.userService.updateUser(UserToUpdate).subscribe(
      () => {
        this.loadUsers();
        this.showSuccessToast('client modifiée avec succès.'); // Recharger la liste des utilisateurs après la mise à jour
        
      },
      error => {
       
        console.error('Error updating user:', error);
        this.showErrorToast('Erreur lors de la modification du client.');
      
      }
    );
    
  }


  addUser(user: User) {
    this.userService.addUser(user).subscribe(
      () => {
        this.totalUsers ++ ;
        this.loadUsers(); // Recharger la liste des utilisateurs après ajout
        this.showSuccessToast('Client ajoutée avec succès.');
       
      },
      error => {
        console.error('Error adding user:', error);
        this.showErrorToast('Erreur lors de l\'ajout du client');
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
    const toastElement = document.getElementById('liveToastSucc');
    console.log(toastElement);
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErr');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }


}
