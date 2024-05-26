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
  inscritsFormations: number[] = [];
  selectedFormation: Formation | null = null;
  filterValue: string = '';
  dropdownOpen: boolean = false;
  userId: number | null = null;
  popUpVisible: boolean = false;
  popUpMessage: string = '';

  constructor(private formationService: FormationService) { }

  ngOnInit(): void {
    this.loadUserId();
    this.loadInscritFormations();
  }

  loadUserId() {
    const storedUserId = localStorage.getItem('userId');
    if (storedUserId) {
      this.userId = parseInt(storedUserId, 10);
    }
  }

  loadInscritFormations() {
    if (this.userId !== null) {
      this.formationService.getFormationsByUser(this.userId).subscribe(
        (formations: Formation[]) => {
          this.inscritsFormations = formations.map(formation => formation.id_produit);
          this.loadFormations();
        },
        (error: any) => {
          console.error('Error loading user formations:', error);
        }
      );
    }
  }

  loadFormations() {
    this.formationService.getFormations(1, 10).subscribe(
      (formations: Formation[]) => {
        this.formations = formations
          .map(formation => ({
            ...formation,
            date_debut: new Date(formation.date_debut),
            date_fin: new Date(formation.date_fin),
            date_fin_inscription: new Date(formation.date_fin_inscription)
          }))
          .filter(formation => !this.inscritsFormations.includes(formation.id_produit));
      },
      (error: any) => {
        console.error('Error loading formations:', error);
      }
    );
  }

  selectFormation(formation: Formation) {
    this.filterValue = formation.titre;
    this.selectedFormation = formation;
    this.dropdownOpen = false; // Close dropdown after selection
  }

  openDropdown() {
    this.dropdownOpen = true;
  }

  inscrire() {
    if (this.selectedFormation && this.userId !== null) {
      this.formationService.inscrireUtilisateur(this.selectedFormation.id_produit, this.userId).subscribe(
        (response: any) => {
          console.log('Inscription successful:', response);
          this.showPopUp('Inscription réussie !');
          this.selectedFormation = null;
          this.filterValue = '';
          this.loadInscritFormations(); // Reload inscriptions to update the list
        },
        (error: any) => {
          console.error('Error during inscription:', error);
          this.showPopUp('Erreur lors de l\'inscription.');
        }
      );
    } else {
      console.log('No formation selected or user ID is missing.');
      this.showPopUp('Veuillez sélectionner une formation.');
    }
  }

  showPopUp(message: string): void {
    this.popUpMessage = message;
    this.popUpVisible = true;
    setTimeout(() => {
      this.popUpVisible = false;
    }, 3000);
  }
}
