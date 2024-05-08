import { Component, OnInit } from '@angular/core';
//import { AuthService } from '../services/auth.service';
import { UserService } from '../services/user.service';
import { User } from '../models/user.model';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  connectedUser: User | null = null; // Utilisateur connecté (initialisé à null par défaut)

  constructor(/*private authService: AuthService,*/ private userService: UserService) {}

  ngOnInit(): void {
  //  const token = this.authService.getToken();

   /* if (token) {
      const decodedToken: any = this.authService.getUserFromToken(token); // Décode le token pour obtenir l'identifiant de l'utilisateur methode ds le service des authentifics
      const userId = decodedToken.userId;

      this.userService.getUserById(userId).subscribe(
        (user: User) => {
          this.connectedUser = user;
        },
        (error) => {
          console.error('Erreur lors de la récupération des informations de l\'utilisateur :', error);
        }
      );
    }*/
  }
/* pret a deco en fcn des nom des methodes
  logout(): void {
    this.authService.removeToken();
    this.connectedUser = null; // Réinitialiser l'utilisateur connecté
    // Rediriger l'utilisateur vers la page de connexion ou autre action
  }*/
}
