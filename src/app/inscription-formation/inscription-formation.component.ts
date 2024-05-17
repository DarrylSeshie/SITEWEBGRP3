import { Component, OnInit } from '@angular/core';
import { FormationService } from '../services/formation.service';

interface Formation {
  id_produit: number;
  titre: string;
  sous_titre: string;
  date_debut: Date;
  date_fin: Date;
  date_fin_inscription: Date;
  descriptif: string;
  objectif: string;
  contenu: string;
  methodologie: string;
  public_cible: string;
  prix: number;
  id_image: number;
  id_lieu: number;
  id_type_produit: number;
}

@Component({
  selector: 'app-inscription-formation',
  templateUrl: './inscription-formation.component.html',
  styleUrls: ['./inscription-formation.component.css']
})
export class InscriptionFormationComponent implements OnInit {
  formations: Formation[] = [];
  selectedFormation: Formation | null = null;
  filterValue: string = '';  // Initialise filterValue comme une chaîne vide

  constructor(private formationService: FormationService) { }

  ngOnInit(): void {
    this.loadFormations();
  }

  loadFormations() {
    this.formationService.getFormations(1, 10).subscribe(
      (formations: any[]) => {
        this.formations = formations.map(formation => ({
          ...formation,
          date_debut: new Date(formation.date_debut),
          date_fin: new Date(formation.date_fin),
          date_fin_inscription: new Date(formation.date_fin_inscription)
        }));
      },
      (error) => {
        console.error('Error loading formations:', error);
      }
    );
  }

  selectFormation(formation: Formation) {
    this.selectedFormation = formation;
  }

  inscrire() {
    if (this.selectedFormation) {
      console.log('Inscription à la formation:', this.selectedFormation);
      // Appel du service pour inscrire l'utilisateur à la formation
      // this.formationService.inscrireUtilisateur(this.selectedFormation.id_produit);
    }
  }
}
