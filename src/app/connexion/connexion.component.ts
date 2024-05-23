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
        this.cookieService.set("token", token.access_token);
        localStorage.setItem("userId", token.userId);
        this.service.setLoggedIn(true);
        this.router.navigate(["/acceuil"]);
      },
      error: (errorMsg) => {
        this.errorMsg = errorMsg.error.error;
        this.service.setLoggedIn(false);
      }
    });
  }
  
}