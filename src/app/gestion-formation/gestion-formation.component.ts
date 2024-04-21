import { Component } from '@angular/core';
import { FormationService } from '../services/formation.service';
import { Observable } from 'rxjs';
import { Formation } from '../models/formation.model';
import { TypeProduit } from '../models/typeProduit.model';
import { TypeProduitService } from '../services/typeProduit.service';


@Component({
  selector: 'app-gestion-formation',
  templateUrl: './gestion-formation.component.html',
  styleUrl: './gestion-formation.component.css'
})
export class GestionFormationComponent {

  
  selectedFormation!: Formation; 
  currentPage: number = 1;
  pageSize: number = 10;
  Formations!: Observable<Formation[]>;
  Formations2!: Observable<Formation[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};


  constructor(private formationService:FormationService) { }

  ngOnInit(): void {
    this.loadFormations();
  }
  

  loadFormations():void {
  this.Formations = this.formationService.getFormations(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadFormations();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
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
      this. Formations2 = this.formationService.searchFormationsByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadFormations();
    }
    }
  
  

  deleteFormation(formationId: number) {
    this.formationService.deleteFormation(formationId).subscribe(() => {
      this.loadFormations(); 
    });
  }

  updateFormation(formation: Formation) {
    this.formationService.updateFormation(formation); 
  }

  addFormation(formation: Formation) {
    this.formationService.addFormation(formation); 
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
}




