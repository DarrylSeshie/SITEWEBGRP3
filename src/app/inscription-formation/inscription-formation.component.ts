import { Component, OnInit } from '@angular/core';
import { FormationService } from '../services/formation.service';
import { Formation } from '../models/formation.model';

@Component({
  selector: 'app-inscription-formation',
  templateUrl: './inscription-formation.component.html',
  styleUrls: ['./inscription-formation.component.css']
})
export class InscriptionFormationComponent implements OnInit {
  formations: Formation[] = [];
  selectedFormation: Formation | null = null;
  filterValue: string = '';
  dropdownOpen: boolean = false;
  userId: number | null = null; // Initialize as null to handle potential absence in localStorage

  constructor(private formationService: FormationService) { }

  ngOnInit(): void {
    this.loadFormations();
    this.loadUserId();
  }

  loadFormations() {
    this.formationService.getFormations(1, 10).subscribe(
      (formations: Formation[]) => {
        this.formations = formations.map(formation => ({
          ...formation,
          date_debut: new Date(formation.date_debut),
          date_fin: new Date(formation.date_fin),
          date_fin_inscription: new Date(formation.date_fin_inscription)
        }));
      },
      (error: any) => {
        console.error('Error loading formations:', error);
      }
    );
  }

  loadUserId() {
    const storedUserId = localStorage.getItem('userId');
    if (storedUserId) {
      this.userId = parseInt(storedUserId, 10);
    }
  }

  selectFormation(formation: Formation) {
    this.filterValue = formation.titre;
    this.selectedFormation = formation;
    this.dropdownOpen = true;
  }

  openDropdown() {
    this.dropdownOpen = true;
  }

  inscrire() {
    if (this.selectedFormation && this.userId !== null) {
      this.formationService.inscrireUtilisateur(this.selectedFormation.id_produit, this.userId).subscribe(
        (response: any) => {
          console.log('Inscription successful:', response);
          this.selectedFormation = null;
          this.filterValue = '';
        },
        (error: any) => {
          console.error('Error during inscription:', error);
        }
      );
    } else {
      console.log('No formation selected or user ID is missing.');
    }
  }
}
