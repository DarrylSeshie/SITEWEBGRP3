import { Component, OnInit } from '@angular/core';
import { Lieu } from '../models/lieu.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { LieuService } from '../services/lieu.service';


@Component({
  selector: 'app-gestion-lieu',
  templateUrl: './gestion-lieu.component.html',
  styleUrl: './gestion-lieu.component.css'
})
export class GestionLieuComponent {


  
  selectedLieu!: Lieu; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  lieux!: Observable<Lieu[]>;
  lieux2!: Observable<Lieu[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};


  constructor(private lieuService: LieuService) { }

  ngOnInit(): void {
    this.loadLieux();
  }

  loadLieux() {
  this.lieux = this.lieuService.getLieux(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadLieux();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadLieux();
    }
  }

  toggleDetails(lieu: Lieu) {
    const lieuId = lieu.id_lieu;
    if (this.userDetailVisible[lieuId]) {
      this.userDetailVisible[lieuId] = false;
    } else {
      this.userDetailVisible[lieuId] = true;
    }
  }

  searchLieuByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this. lieux2 = this.lieuService.searchLieuxByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadLieux();
    }
  }
  

  deleteLieu(lieuId: number) {
    this.lieuService.deleteLieu(lieuId).subscribe(() => {
      this.loadLieux(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateLieu(lieu: Lieu) {
    this.lieuService.updateLieu(lieu); // Appeler la méthode de mise à jour de l'utilisateur
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addLieu(lieu: Lieu) {
    this.lieuService.addLieu(lieu); // Appeler la méthode pour ajouter un utilisateur
  }

  selectLieu(lieuId: number) {
    this.lieuService.getLieuById(lieuId).subscribe(
      lieu => {
        this.selectedLieu = lieu;
        // Toggle the visibility of user details
        this.toggleDetails(lieu);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }

}
