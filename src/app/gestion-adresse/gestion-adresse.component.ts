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
  showAddAdresseForm: boolean = false;
  showUpdateAdresseForm :boolean = false;


    // message de notifs
    successMessage: string = '';
    errorMessage: string = '';

    adresse :  Adresse= {
      id_adresse: -1,
      rue_numero: "",
      code_postal:0,
      localite:"",
      pays:""
    };

    AdresseToUpdate: Adresse | null = null;
   
  constructor(private adresseService:AdresseService) { }






  ngOnInit(): void {
    this.loadAdresses();
  }

  loadAdresses() {
  this.Adresses = this.adresseService.getAdresses(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  

  toggleAddAdresseForm(): void {
    if (this.showAddAdresseForm || this.showUpdateAdresseForm) {
      this.showAddAdresseForm = false;
      this.showUpdateAdresseForm = false;
    } else {
      this.showAddAdresseForm = true;
    }
  }

  toggleUpdateAdresseForm(Adresse: Adresse) {
    this.AdresseToUpdate = Adresse;
    this.showUpdateAdresseForm = true;
    this.showAddAdresseForm = false; // Assurez-vous que le formulaire d'ajout est masqué
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
    this.adresseService.deleteAdresse(adresseId).subscribe(
      () => {
        this.loadAdresses();
        this.showSuccessToast('Adresse supprimée avec succès.');
      },
      (error) => {
        console.error('Error deleting adresse:', error);
        this.showErrorToast('Erreur lors de la suppression de l\'adresse.');
      }
    );
  }

  updateAdresse(AdresseToUpdate: Adresse) {
  
    this.adresseService.updateAdresse(AdresseToUpdate).subscribe(
      () => {
        this.loadAdresses();
        this.showSuccessToast('Adresse modifiée avec succès.');
       this.AdresseToUpdate = AdresseToUpdate ;
      },
      (error) => {
        console.error('Error updating Adresse:', error);
        this.showErrorToast('Erreur lors de la modification de l\'Adresse.');
      }
    );
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addAdresse(adresse: Adresse) {
    this.adresseService.addAdresse(adresse).subscribe(
      () => {
        
        this.loadAdresses();
        this.showSuccessToast('Adresse ajoutée avec succès.');
        
       
      },
      (error) => {
        console.error('Error adding Adresse:', error);
        this.showErrorToast('Erreur lors de l\'ajout de l\'Adresse.');
        this.loadAdresses();
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


  showSuccessToast(message: string) {
    const toastElement = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.successMessage = message;
    this.errorMessage = '';
  }

   showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }
}
