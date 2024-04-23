import { Component } from '@angular/core';
import { ImageService } from '../services/image.service';
import { Observable } from 'rxjs';
import { Image } from '../models/image.model';


declare const bootstrap: any;
@Component({
  selector: 'app-gestion-image',
  templateUrl: './gestion-image.component.html',
  styleUrl: './gestion-image.component.css'
})
export class GestionImageComponent {
  
  selectedImage!: Image; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 9;
  images!: Observable<Image[]>;
  images2!: Observable<Image[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  showDefaultImages: boolean = true;
  userDetailVisible: { [key: number]: boolean } = {};

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';

  constructor(private imageService:ImageService) { }

  ngOnInit(): void {
    this.loadImages();
  }
  

  loadImages():void {
  this.images = this.imageService.getImages(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  this.showDefaultImages = true;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadImages();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadImages();
    }
  }

  toggleDetails(image: Image) {
    const imageId = image.id_image;
    if (this.userDetailVisible[imageId]) {
      this.userDetailVisible[imageId] = false;
    } else {
      this.userDetailVisible[imageId] = true;
    }
  }

  searchImageByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this.images2 = this.imageService.searchImagesByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche

      // Vérifie si aucun utilisateur n'est trouvé après la recherche
      this.images2.subscribe(
        (users) => {
          if (users.length === 0) {
            const toastElement = document.getElementById('liveToast');
            const toastBootstrap = new bootstrap.Toast(toastElement);
            toastBootstrap.show();
            this.successMessage = 'Aucune image trouvé pour ce nom ';
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
      this.loadImages();
    }
  }
  

  deleteImage(imageId: number) {
    // Appel du service pour supprimer l'utilisateur
    this.imageService.deleteImage(imageId).subscribe(
      () => {
        this.loadImages(); 
        // Afficher le toast de confirmation
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Image supprimer avec succès.';
        this.errorMessage = ''; 
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error deleting user:', error);
        this.errorMessage = 'Erreur de suppression de l\'image car celui ci est affilié à quelque chose  ';
        this.successMessage = '';
      }
    );
  }

  updateImage(image: Image) {
    this.imageService.updateImage(image).subscribe(
      () => {
        this.loadImages(); // Recharger la liste des utilisateurs après la mise à jour
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Image modifié avec succès.';
        this.errorMessage = ''; // Réinitialiser le message d'erreur
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error updating user:', error);
        this.errorMessage = 'Erreur lors de la modification de l\'image: ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }

  addImage(image: Image) {
   
    this.imageService.addImage(image).subscribe(
      () => {
        this.loadImages(); // Recharger la liste des utilisateurs après ajout
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        this.successMessage = 'Image ajouté avec succès.';
        this.errorMessage = ''; 
       
      },
      error => {
        const toastElement = document.getElementById('liveToast');
        const toastBootstrap = new bootstrap.Toast(toastElement);
        toastBootstrap.show();
        console.error('Error adding user:', error);
        this.errorMessage = 'Erreur lors de l\'ajout de l\'image : ' + error.message;
        this.successMessage = ''; // Réinitialiser le message de succès
      }
    );
  }
  selectImage(imageId: number) {
    this.imageService.getImageById(imageId).subscribe(
      image => {
        this.selectedImage = image;
        // Toggle the visibility of user details
        this.toggleDetails(image);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }

}
