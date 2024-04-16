import { Component } from '@angular/core';
import { InstitutionService } from '../services/institution.service';
import { Observable } from 'rxjs';
import { Institution } from '../models/institution.model';

@Component({
  selector: 'app-gestion-institution',
  templateUrl: './gestion-institution.component.html',
  styleUrl: './gestion-institution.component.css'
})
export class GestionInstitutionComponent {

  
  selectedInstitution!: Institution; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  institutions!: Observable<Institution[]>;
  institutions2!: Observable<Institution[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};


  constructor(private institutionService:InstitutionService) { }

  ngOnInit(): void {
    this.loadInstitutions();
  }

  loadInstitutions() {
  this.institutions = this.institutionService.getInstitutions(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadInstitutions();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadInstitutions();
    }
  }

  toggleDetails(institution: Institution) {
    const institutionId = institution.id_institution;
    if (this.userDetailVisible[institutionId]) {
      this.userDetailVisible[institutionId] = false;
    } else {
      this.userDetailVisible[institutionId] = true;
    }
  }

  searchInstitutionByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this. institutions2 = this.institutionService.searchInstitutionsByName(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadInstitutions();
    }
  }
  

  deleteInstitution(institutionId: number) {
    this.institutionService.deleteInstitution(institutionId).subscribe(() => {
      this.loadInstitutions(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateInstitution(institution: Institution) {
    this.institutionService.updateInstitution(institution); // Appeler la méthode de mise à jour de l'utilisateur
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addInstitution(institution: Institution) {
    this.institutionService.addInstitution(institution); // Appeler la méthode pour ajouter un utilisateur
  }
  selectInstitution(institutionId: number) {
    this.institutionService.getInstitutionById(institutionId).subscribe(
      institution => {
        this.selectedInstitution = institution;
        // Toggle the visibility of user details
        this.toggleDetails(institution);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }
}
