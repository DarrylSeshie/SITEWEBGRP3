import { Component, OnInit } from '@angular/core';
import { Formation } from '../models/formation.model';
import { FormationService } from '../services/formation.service';

@Component({
  selector: 'app-voir-formations',
  templateUrl: './voir-formations.component.html',
  styleUrls: ['./voir-formations.component.css']
})
export class VoirFormationsComponent implements OnInit {
  selectedMenu: string = 'future';
  formations: Formation[] = [];
  formations2: Formation[] = [];
  userId: number;

  constructor(private formationService: FormationService) {
    this.userId = Number(localStorage.getItem('userId'));
  }

  ngOnInit(): void {
    this.loadFormations();
  }

  selectMenu(menu: string): void {
    this.selectedMenu = menu;
    this.loadFormations();
  }

  loadFormations(): void {
    if (this.userId) {
      this.formationService.getFormationsByUser(this.userId).subscribe(
        formations => {
          this.formations = formations;
        },
        error => {
          console.error('Error fetching formations', error);
        }
      );
      this.formationService.getDonneFormationsByUser(this.userId).subscribe(
        formations => {
          this.formations2 = formations;
        },
        error => {
          console.error('Error fetching donne formations', error);
        }
      );
    }
  }

  getFilteredFormations(status: string): Formation[] {
    return this.formations.filter(formation => formation.status === status);
  }

  getFilteredFormationsByRole(roleId: number): Formation[] {
    return this.formations.filter(formation => formation.id_role === roleId);
  }

  deleteParticipant(id_produit: number): void {
    this.formationService.deleteParticipant(this.userId, id_produit).subscribe(
      response => {
        this.loadFormations(); // Refresh the list after deletion
      },
      error => {
        console.error('Error deleting participant', error);
      }
    );
  }

  hasRole(roleId: number): boolean {
    return this.formations.some(formation => formation.id_role === roleId);
  }
}
