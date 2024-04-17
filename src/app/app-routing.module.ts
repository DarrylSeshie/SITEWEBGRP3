import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { GestionFormateurComponent } from './gestion-formateur/gestion-formateur.component';
import { GestionFormationComponent } from './gestion-formation/gestion-formation.component';
import { GestionImageComponent } from './gestion-image/gestion-image.component';
import { GestionInstitutionComponent } from './gestion-institution/gestion-institution.component';
import { GestionUtilisateurComponent } from './gestion-utilisateur/gestion-utilisateur.component';
import { GestionLieuComponent } from './gestion-lieu/gestion-lieu.component';
import { AcceuilComponent } from './acceuil/acceuil.component';
//import { GestionnaireComponent } from './gestionnaire/gestionnaire.component';
import { GestionAdresseComponent } from './gestion-adresse/gestion-adresse.component';
import { InscriptionClientComponent } from './inscription-client/inscription-client.component';
import { VoirFormationsComponent } from './voir-formations/voir-formations.component';
import { VoirProfilComponent } from './voir-profil/voir-profil.component';

const routes: Routes = [
  /*Indiquez les routes a suivre*/ 
  
    {
      path:'acceuil', component: AcceuilComponent // par defaut elle affiche le component acceuils
    },
    {
      path: 'gestionformateurs', component: GestionFormateurComponent
    },
    {
      path: 'gestionformations', component: GestionFormationComponent
    },
    {
      path: 'gestionimages', component: GestionImageComponent
    },
    {
      path: 'gestionutilisateurs', component: GestionUtilisateurComponent
    },
    {
      path: 'gestioninstitutions', component: GestionInstitutionComponent
    },
    {
      path: 'gestionlieux', component: GestionLieuComponent
    },
    /*{
      path: 'gestion', component: GestionnaireComponent
    }, */
    {
      path: 'gestionadresses', component: GestionAdresseComponent
    },

    {
      path: 'inscription-client', component: InscriptionClientComponent
    },
    {
      path: 'voir-formations', component: VoirFormationsComponent
    },
    {
      path: 'voir-profil', component: VoirProfilComponent
    }



  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
