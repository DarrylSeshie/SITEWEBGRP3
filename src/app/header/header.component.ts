import { Component, OnInit } from '@angular/core';
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
  connectedUser!: User;// Utilisateur connecté (initialisé à null par défaut)
  successMessage: string = '';
  errorMessage: string = '';

  exportedData: any;

  constructor(private router: Router, private userService: UserService ,private backupService: BackupService,private cookieService: CookieService) {}

  ngOnInit(): void {
    this.loadCurrentUser();
  }

  loadCurrentUser(): void {
    const token = this.cookieService.get("token");

    if (token) {
      console.log('Token trouvé:', token);
      this.userService.validateJwt(token).subscribe(
        decodedToken => {
          console.log('Token décodé:', decodedToken);
          const userEmail = decodedToken.email;
          this.userService.getUserByEmail(userEmail).subscribe(
            (user: User) => {
              console.log('Utilisateur trouvé:', user);
              this.connectedUser = user;
            },
            error => {
              console.error('Erreur lors de la récupération des informations de l\'utilisateur :', error);
            }
          );
        },
        error => {
          console.error('Erreur lors de la validation du token :', error);
        }
      );
    } else {
      console.log('Token non trouvé');
    }
  }


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
