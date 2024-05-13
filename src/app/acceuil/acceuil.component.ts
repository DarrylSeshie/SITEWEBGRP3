import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormationService } from '../services/formation.service';
import { Observable, Subscription, interval } from 'rxjs';
import { Formation } from '../models/formation.model';
import { shareReplay } from 'rxjs/operators';


@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrl: './acceuil.component.css'
})
export class AcceuilComponent implements OnInit, OnDestroy{

  Formations!: Observable<Formation[]>;
  private countdownIntervalSubscription: Subscription | undefined;

  constructor(private formationService:FormationService) { }
 
  ngOnInit(): void {
    this.Formations = this.formationService.get3ProduitsAvenir().pipe(
      shareReplay(1) // Mettre en cache les données des formations pour les réutiliser
    );

    // Mettre à jour le décompte chaque seconde
    this.countdownIntervalSubscription = interval(1000).subscribe(() => {
      // Rafraîchir l'affichage du décompte en réassignant Formations$
      this.Formations = this.Formations.pipe(
        shareReplay(1) // Mettre à jour les données et les réutiliser
      );
    });
  }
    

  ngOnDestroy(): void {
    // Arrêter l'intervalle lorsque le composant est détruit pour éviter les fuites de mémoire
    if (this.countdownIntervalSubscription) {
      this.countdownIntervalSubscription.unsubscribe();
    }
  }
  
 /* loadFormations(): void {
    this.Formations = this.formationService.get3ProduitsAvenir();
  }*/


  getCountdown(targetDateStr: string): string {
    const targetDate = new Date(targetDateStr);
    const now = new Date();
  
    if (now >= targetDate) {
      return "La période d'inscription est terminée.";
    }
  
    const diff = Math.abs(targetDate.getTime() - now.getTime()) / 1000;
    const days = Math.floor(diff / (24 * 60 * 60));
    const hours = Math.floor((diff % (24 * 60 * 60)) / (60 * 60));
    const minutes = Math.floor((diff % (60 * 60)) / 60);
    const seconds = Math.floor(diff % 60);
  
    return `Fin d'inscription dans : ${days} jours, ${hours} heures, ${minutes} minutes, ${seconds} secondes `;
  }


  isRegistrationClosed(dateFinInscription: string): boolean {
    const now = new Date();
    const targetDate = new Date(dateFinInscription);
    return now >= targetDate; // Returns true if the current date is past the target date
  }

}
