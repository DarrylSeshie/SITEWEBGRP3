import { Component } from '@angular/core';
import { Adresse } from '../models/adresse.model';
import { Observable } from 'rxjs';
import { AdresseService } from '../services/adresse.service';

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


  constructor(private adresseService:AdresseService) { }

  ngOnInit(): void {
    this.loadAdresses();
  }

  loadAdresses() {
  this.Adresses = this.adresseService.getAdresses(this.currentPage, this.pageSize);
  this.showSearchResults = false;
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
      this. Adresses2 = this.adresseService.searchAdressesByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadAdresses();
    }
  }
  

  deleteAdresse(adresseId: number) {
    this.adresseService.deleteAdresse(adresseId).subscribe(() => {
      this.loadAdresses(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateAdresse(adresse: Adresse) {
    this.adresseService.updateAdresse(adresse); // Appeler la méthode de mise à jour de l'utilisateur
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addAdresse(adresse: Adresse) {
    this.adresseService.addAdresse(adresse); // Appeler la méthode pour ajouter un utilisateur
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
}
