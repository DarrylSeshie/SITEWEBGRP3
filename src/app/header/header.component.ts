import { Component, OnInit } from '@angular/core';
//import { AuthService } from '../services/auth.service';
import { UserService } from '../services/user.service';
import { User } from '../models/user.model';
import { BackupService } from '../services/backup.service';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';

declare const bootstrap: any;
@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  connectedUser: User | null = null; // Utilisateur connecté (initialisé à null par défaut)
  successMessage: string = '';
  errorMessage: string = '';

  exportedData: any;

  constructor(private router: Router, private userService: UserService ,private backupService: BackupService,private cookieService: CookieService) {}

  ngOnInit(): void {
    this.loadCurrentUser();
  }

  loadCurrentUser(): void {
    const token = this.userService.getToken();
    if (token) {
      const decodedToken = this.userService.decodeToken();
      const userId = decodedToken.userId; // Assurez-vous que cette clé correspond à ce que renvoie le token
  
      this.userService.getUserById(userId).subscribe(
        (user: User) => {
          this.connectedUser = user;
        },
        (error) => {
          console.error('Erreur lors de la récupération des informations de utilisateur :', error);
        }
      );
    }
  }

 /* logout(): void {
    localStorage.removeItem('token');
    this.connectedUser = null; // Réinitialiser l'utilisateur connecté
    this.router.navigate(['/']); // Redirige vers la page de connexion
  }*/

  logout(): void {
    this.cookieService.delete('token'); // Supprime le token du cookie
    this.userService.logout(); // Mise à jour de l'état de connexion dans AuthService
    this.router.navigate(['/']); // Redirige vers la page de connexion
  }


  
  exportDb(): void {
    this.backupService.exportDatabase().subscribe(
      (data) => {
        console.log('Réponse du serveur :', data);
        this.exportedData = data; // Afficher la réponse dans le template
        this.showSuccessToast('sauvgarde avec succès.'); 
      },
      (error) => {
        console.error('Erreur lors de l\'export de la base de données :', error);
        this.showErrorToast('Erreur lors de la sauvegarde.');
        // Gérer l'erreur ici
      }
    );
  }
 
  

 
  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSuccess');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastError');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }
}
