import { Component } from '@angular/core';
import { FormationService } from '../services/formation.service';
import { Observable } from 'rxjs';
import { Formation } from '../models/formation.model';
import { TypeProduit } from '../models/typeProduit.model';
import { TypeProduitService } from '../services/typeProduit.service';
import { User } from '../models/user.model';
import { FormateurService } from '../services/formateur.service';
import { LieuService } from '../services/lieu.service';
import { Lieu } from '../models/lieu.model';
import { ImageService } from '../services/image.service';
import { Image } from '../models/image.model';



declare const bootstrap: any;
@Component({
  selector: 'app-gestion-formation',
  templateUrl: './gestion-formation.component.html',
  styleUrl: './gestion-formation.component.css'
})
export class GestionFormationComponent {

  
  selectedFormation!: Formation; 
  currentPage: number = 1;
  pageSize: number = 3;
  Formations!: Observable<Formation[]>;
  Formations2!: Observable<Formation[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};
  showAddProduitForm: boolean = false;
  showUpdateProduitForm :boolean = false;
  totalUsers!: number;


  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';



  produit: Formation = {
    id_produit: -1,
    titre: '',
    sous_titre: '',
    date_debut: new Date,
    date_fin: new Date,
    date_fin_inscription: new Date,
    descriptif: '',
    objectif: '',
    contenu: '',
    methodologie: '',
    public_cible: '',
    prix: 0.00,
    id_image: -1,
    id_lieu: -1,
    id_type_produit: 1,
    id_formateur: -1,
  };
  formateurs : User[] = [];
  lieux : Lieu[] = [];
  types : TypeProduit[] = [];
  images : Image[] = [];


  ProduitToUpdate: Formation | null = null;
  constructor(private formationService:FormationService,private formateurService: FormateurService,
    private lieuService: LieuService ,private imageService: ImageService,
    private typeService: TypeProduitService
  ) { }

  ngOnInit(): void {
    this.loadFormations();
    this.loadCount();
    this.loadFormateurs();
    this.loadLieux();
    this.loadTypesProduits();
    this.loadImages();
  }
  loadTypesProduits(){
    this.typeService.getTypeProduits(1, 10).subscribe(
      (types) => {
        this.types = types;
      },
      (error) => {
        console.error('Error fetching formateurs:', error);
      }
    );
  }
  loadImages(){
    this.imageService.getImages(1, 20).subscribe(
      (images) => {
        this.images = images;
      },
      (error) => {
        console.error('Error fetching formateurs:', error);
      }
    );
  }
  
  loadLieux(){
    this.lieuService.getLieux(1, 20).subscribe(
      (lieux) => {
        this.lieux = lieux;
      },
      (error) => {
        console.error('Error fetching formateurs:', error);
      }
    );
  }
  loadFormateurs(){
    this.formateurService.getUsers(1, 20).subscribe(
      (formateurs) => {
        this.formateurs = formateurs;
      },
      (error) => {
        console.error('Error fetching formateurs:', error);
      }
    );
  }

  loadFormations():void {
  this.Formations = this.formationService.getFormations(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

   
loadCount() {
  this.formationService.getTotalUsersCount().subscribe(
    total => {
      this.totalUsers = total;
    },
    error => {
      console.error('Error fetching total users count:', error);
    }
  );
}


  
  toggleAddProduitForm(): void {
    if (this.showAddProduitForm || this.showUpdateProduitForm) {
      this.showAddProduitForm = false;
      this.showUpdateProduitForm = false;
    } else {
      this.showAddProduitForm = true;
    }
  }

  toggleUpdateProduitForm(Produit: Formation) {
    this.ProduitToUpdate = Produit;
    this.showUpdateProduitForm = true;
    this.showAddProduitForm = false; // Assurez-vous que le formulaire d'ajout est masqué
  }

  
  nextPage() {
    const totalPages = Math.ceil(this.totalUsers / this.pageSize);
    if (this.currentPage < totalPages) {
      this.currentPage++;
      this.loadFormations();
    }
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
     // console.log('Current Page:', this.currentPage);
      this.loadFormations();
    }
  }

  toggleDetails(formation: Formation) {
    const formationId = formation.id_produit;
    if (this.userDetailVisible[formationId]) {
      this.userDetailVisible[formationId] = false;
    } else {
      this.userDetailVisible[formationId] = true;
    }
  }

  searchFormationsByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.Formations2 = this.formationService.searchFormationsByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.Formations2.subscribe(
        (users) => {
          if (users.length === 0) {
            const toastElement = document.getElementById('liveToastSuccesso');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucun utilisateur trouvé pour ce nom ';
            this.errorMessage = ''; 
           
          }
        },
        (error) => {
          const toastElement = document.getElementById('liveToastErroro');
          const toastBootstrap = new bootstrap.Toast(toastElement);
          toastBootstrap.show();
          console.error('Error search user:', error);
          this.errorMessage = 'Erreur de recherche , vous avez mal encodez  ';
          this.successMessage = '';
        }
      );
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadFormations();
    }
    }
  
  

  deleteFormation(formationId: number) {
    // Appel du service pour supprimer l'utilisateur
    this.formationService.deleteFormation(formationId).subscribe(
      () => {
        this.totalUsers -- ;
        this.loadFormations(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToastSuccesso');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Formation supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToastErroro');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression de la Formation car des utilisateurs se sont inscris  ';
        this.successMessage = '';
      }
    );
  }



  updateFormation(ProduitToUpdate: Formation) {
    this.formationService.updateFormation(ProduitToUpdate).subscribe(
      () => {
        this.loadFormations(); // Recharger la liste des utilisateurs après la mise à jour
        this.showSuccessToast('Formation modifiée avec succès.');
      },
      error => {
        
       
        console.error('Error updating user:', error);
        this.showErrorToast('Erreur lors de la modification de la formation.');
      }
    ); 
  }

  addFormation(formation: Formation) {
    this.formationService.addFormation(formation).subscribe(
      () => {
        this.totalUsers ++ ;
        this.loadFormations(); // Recharger la liste des utilisateurs après ajout
        this.showSuccessToast('Formation ajoutée avec succès.');
       
      },
      error => {
        console.error('Error adding formation:', error);
        this.showErrorToast('Erreur lors de l\'ajout de la formation');
        this.loadFormations();
      }
    );
  }


  selectFormation(formationId: number) {
    this.formationService.getFormationById(formationId).subscribe(
      formation => {
        this.selectedFormation = formation;
        // Toggle the visibility of user details
        this.toggleDetails(formation);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }


  
  
  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSuccesso');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErroro');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }

}




