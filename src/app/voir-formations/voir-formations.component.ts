import { Component, OnInit } from '@angular/core';
import { Formation } from '../models/formation.model';
import { FormationService } from '../services/formation.service';
declare const bootstrap: any;
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
 


   // message de notifs
   successMessage: string = '';
   errorMessage: string = '';

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

  getPastDonneFormations(): Formation[] {
    return this.formations2.filter(formation => formation.status === 'past');
  }

  deleteParticipant(id_produit: number): void {
    this.formationService.deleteParticipant(this.userId, id_produit).subscribe(
      response => {
        this.loadFormations(); // Refresh the list after deletion
        this.showSuccessToast(' Vous vous êtes bien désinscris ');
      },
      error => {
        console.error('Error deleting participant', error);
        this.showErrorToast('Erreur lors de la desinscription.');
      }
    );
  }



  hasRole(roleId: number): boolean {
    return this.formations.some(formation => formation.id_role === roleId);
  }

  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSuccessahh');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErrorahh');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }

}
