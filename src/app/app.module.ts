import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http'; // importer une seul fois
import { CookieService } from 'ngx-cookie-service';
import { RouterOutlet } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { GestionnaireComponent } from './gestionnaire/gestionnaire.component';
import { HeaderComponent } from './header/header.component';
import { GestionUtilisateurComponent } from './gestion-utilisateur/gestion-utilisateur.component';
import { GestionFormateurComponent } from './gestion-formateur/gestion-formateur.component';
import { GestionFormationComponent } from './gestion-formation/gestion-formation.component';
import { GestionInstitutionComponent } from './gestion-institution/gestion-institution.component';
import { GestionImageComponent } from './gestion-image/gestion-image.component';
import { GestionLieuComponent } from './gestion-lieu/gestion-lieu.component';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { GestionAdresseComponent } from './gestion-adresse/gestion-adresse.component';

import { FormationService } from './services/formation.service';
import { TypeProduitService } from './services/typeProduit.service';
import { UserService } from './services/user.service'; // faire import de chaque service utiliser
import { FormateurService } from './services/formateur.service';
import { LieuService } from './services/lieu.service';
import { AdresseService } from './services/adresse.service';
import { InstitutionService } from './services/institution.service';
import { ImageService } from './services/image.service';
import { VoirFormationsComponent } from './voir-formations/voir-formations.component';
import { VoirProfilComponent } from './voir-profil/voir-profil.component';
import { InscriptionFormationComponent } from './inscription-formation/inscription-formation.component';
import { VoirProfileService } from './services/voirProfile.service';
import { RoleService } from './services/role.service';
import { BackupService } from './services/backup.service';
import { ConnexionComponent } from './connexion/connexion.component';
import { RegistrationFormComponent } from './registration-form/registration-form.component';






@NgModule({
  declarations: [
    AppComponent,
    GestionnaireComponent,
    HeaderComponent,
    GestionUtilisateurComponent,
    GestionFormateurComponent,
    GestionFormationComponent,
    GestionInstitutionComponent,
    GestionImageComponent,
    GestionLieuComponent,
    AcceuilComponent,
    GestionAdresseComponent,
    VoirFormationsComponent,
    VoirProfilComponent,
    InscriptionFormationComponent,
    ConnexionComponent,
    RegistrationFormComponent
    
  
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FormsModule ,
    RouterOutlet,
    ReactiveFormsModule,
    
    
   
  ],
  providers: [ // ajt tout les service  cree ici ici
    UserService,
    FormateurService,
    LieuService,
    AdresseService,
    InstitutionService,
    ImageService,
    VoirProfileService,
    FormationService,
    TypeProduitService,
    RoleService,
    BackupService,
    CookieService
    
    
  ], 
  bootstrap: [AppComponent]
})
export class AppModule { }
