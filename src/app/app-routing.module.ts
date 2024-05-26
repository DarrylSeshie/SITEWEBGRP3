import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { authGuard } from './auth.guard'; 
import { roleGuard } from './role.guard'; // import guard role


import { GestionFormateurComponent } from './gestion-formateur/gestion-formateur.component';
import { GestionFormationComponent } from './gestion-formation/gestion-formation.component';
import { GestionImageComponent } from './gestion-image/gestion-image.component';
import { GestionInstitutionComponent } from './gestion-institution/gestion-institution.component';
import { GestionUtilisateurComponent } from './gestion-utilisateur/gestion-utilisateur.component';
import { GestionLieuComponent } from './gestion-lieu/gestion-lieu.component';
import { AcceuilComponent } from './acceuil/acceuil.component';
//import { GestionnaireComponent } from './gestionnaire/gestionnaire.component';
import { GestionAdresseComponent } from './gestion-adresse/gestion-adresse.component';
import { InscriptionFormationComponent } from './inscription-formation/inscription-formation.component';
import { VoirFormationsComponent } from './voir-formations/voir-formations.component';
import { VoirProfilComponent } from './voir-profil/voir-profil.component';
import { GestionnaireComponent } from './gestionnaire/gestionnaire.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { adminGuard } from './admin.guard';
import { RegistrationFormComponent } from './registration-form/registration-form.component';




const routes: Routes = [
  /*Indiquez les routes a suivre*/ 
  
    {
      path:'acceuil', component: AcceuilComponent , canActivate: [authGuard] 
    },  
    {
      path: 'gestionformateurs', component: GestionFormateurComponent , canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestionformations', component: GestionFormationComponent ,  canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestionimages', component: GestionImageComponent ,  canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestionutilisateurs', component: GestionUtilisateurComponent, canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestioninstitutions', component: GestionInstitutionComponent ,  canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestionlieux', component: GestionLieuComponent , canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'gestionRole', component: GestionnaireComponent ,  canActivate: [authGuard ,adminGuard]
    }, 
    {
      path: 'gestionadresses', component: GestionAdresseComponent ,  canActivate: [authGuard ,roleGuard]
    },
    {
      path: 'inscription-formation', component: InscriptionFormationComponent , canActivate: [authGuard]
    },
    {
      path: 'voir-formations', component: VoirFormationsComponent , canActivate: [authGuard]
    },
    {
      path: 'voir-profil', component: VoirProfilComponent , canActivate: [authGuard]
    },
    {
      path: '', component: ConnexionComponent  // par defaut elle affiche le component login
    },
    {
      path: 'inscription', component: RegistrationFormComponent  // par defaut elle affiche le component login
    }
  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
