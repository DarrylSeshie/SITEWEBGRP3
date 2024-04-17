import { Component } from '@angular/core';
import { ImageService } from '../services/image.service';
import { Observable } from 'rxjs';
import { Image } from '../models/image.model';

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
      this. images2 = this.imageService.searchImagesByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
      this.showDefaultImages = false; // Désactive l'affichage des images normales
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadImages();
    }
  }
  

  deleteImage(imageId: number) {
    this.imageService.deleteImage(imageId).subscribe(() => {
      this.loadImages(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateImage(image: Image) {
    this.imageService.updateImage(image); // Appeler la méthode de mise à jour de l'utilisateur
  }

  addImage(image: Image) {
    this.imageService.addImage(image); // Appeler la méthode pour ajouter un utilisateur
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
