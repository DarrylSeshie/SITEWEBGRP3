import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http'; // importer une seul fois

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

import { UserService } from './services/user.service'; // faire import de chaque service utiliser

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
    GestionAdresseComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule
   
  ],
  providers: [ // ajt tout les service  cree ici ici
    UserService
  ], 
  bootstrap: [AppComponent]
})
export class AppModule { }
