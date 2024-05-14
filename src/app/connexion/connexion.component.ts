import { Component } from '@angular/core';
import { CookieService } from 'ngx-cookie-service';
import { UserService } from '../services/user.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.css']  // Corrigé ici
})

export class ConnexionComponent {
  errorMsg = "";

  constructor(private service: UserService, private cookieService: CookieService, private router: Router) { }

  checkLogin(username: string, password: string) {
    this.service.checkLogin(username, password).subscribe({
      next: (token) => {
        // Assurer que le token est correctement reçu et a une propriété access_token
        if (token && token.access_token) {
          this.cookieService.set("token", token.access_token, 1, "/", undefined, true, "Strict");
          this.router.navigate(["/acceuil"]);
        } else {
          // Gérer l'absence de token ou une structure inattendue
          this.errorMsg = "Token invalide ou absent dans la réponse.";
        }
      },
      error: (errorResponse) => {
        this.errorMsg = errorResponse.error.error || 'Une erreur est survenue';
      }
    });
  }
  
}