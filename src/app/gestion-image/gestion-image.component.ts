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
  showAddImageForm: boolean = false;
  showUpdateImageForm :boolean = false;

  // message de notifs
  successMessage: string = '';
  errorMessage: string = '';


  image: Image = {
    id_image: -1,
    nom: '',
    url_image: '',

  };


  ImageToUpdate: Image | null = null;
  constructor(private imageService:ImageService) { }

  ngOnInit(): void {
    this.loadImages();
  }
  

  
  toggleAddImageForm(): void {
    if (this.showAddImageForm || this.showUpdateImageForm) {
      this.showAddImageForm = false;
      this.showUpdateImageForm = false;
    } else {
      this.showAddImageForm = true;
    }
  }

  toggleUpdateImageForm(image: Image) {
    this.ImageToUpdate = image;
    this.showUpdateImageForm = true;
    this.showAddImageForm = false; // Assurez-vous que le formulaire d'ajout est masqué
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

  updateImage(ImageToUpdate: Image) {
    this.imageService.updateImage(ImageToUpdate).subscribe(
      () => {
        this.loadImages();
        this.showSuccessToast('Image modifiée avec succès.');
        this.ImageToUpdate = null;
        this.toggleAddImageForm();
      },
      (error) => {
        console.error('Error updating image:', error);
        this.showErrorToast('Erreur lors de la modification de l\'image.');
      }
    );
  }

  addImage(image: Image) {
   
    this.imageService.addImage(image).subscribe(
      () => {
        this.image.url_image = ''; 
        this.loadImages();
        this.showSuccessToast('Image ajoutée avec succès.');
        this.toggleAddImageForm();
        
       
      },
      (error) => {
        console.error('Error adding image:', error);
        this.showErrorToast('Erreur lors de l\'ajout de l\'image.');
        this.loadImages();
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

  private showSuccessToast(message: string) {
    const toastElement = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.successMessage = message;
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }

}
