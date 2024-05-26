import { Component, OnInit } from '@angular/core';
import { UserService } from '../services/user.service';
import { User } from '../models/user.model';

@Component({
  selector: 'app-voir-profil',
  templateUrl: './voir-profil.component.html',
  styleUrls: ['./voir-profil.component.css']
})
export class VoirProfilComponent implements OnInit {
  utilisateur: User | null = null; // Initialisation à null
  message: string = '';

  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.userService.getUtilisateur().subscribe(
      (data: User) => {
        this.utilisateur = data;
      },
      error => {
        console.log('Erreur lors de la récupération des données utilisateur : ', error);
      }
    );
  }

  onSubmit() {
    if (this.message) {
      this.userService.sendErrorReport(this.message).subscribe(
        response => {
          if (response) {
            alert('envoyé');
            this.message = ''; // Clear the form
          } else {
            alert('Error submitting message: ' + response.error);
          }
        },
        error => {
          alert('An error occurred while submitting the message');
        }
      );
    } else {
      alert('Please enter a message');
    }
  }
}
