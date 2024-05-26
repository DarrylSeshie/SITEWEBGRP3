import { Component, EventEmitter, Output } from '@angular/core';
import { User } from '../models/user.model';
import { FormsModule } from '@angular/forms';
import { RegistrationApiService } from '../services/registration-api.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-registration-form',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './registration-form.component.html',
  styleUrl: './registration-form.component.css'
})
export class RegistrationFormComponent {
  @Output() addUserEvent = new EventEmitter();

  userToAdd: User = {
    id_utilisateur: -1,
    civilite: '',
    nom: '',
    prenom: '',
    email: '',
    mot_de_passe: '',
    gsm: '',
    profession: '',
    id_role: -1,
    id_adresse: -1,
    adresse: {
      code_postal: 0, // Remplacez par la valeur appropriée depuis votre formulaire
      rue_numero: '', // Remplacez par la valeur appropriée depuis votre formulaire
      localite: '', // Remplacez par la valeur appropriée depuis votre formulaire
      pays: '' // Remplacez par la valeur appropriée depuis votre formulaire
    },
    institution: undefined, // Si vous avez besoin de l'initialiser
    role: undefined, // Si vous avez besoin de l'initialiser
    giografie: '', // Remplacez par la valeur appropriée depuis votre formulaire
  };

  errorMessage = "";

  constructor(private service: RegistrationApiService) { }

  saveUser() {
    const sub = this.service.saveUser(this.userToAdd).subscribe({
      next: (user) => {
        this.addUserEvent.emit(user);
        sub.unsubscribe();
      },
      error: (error) => {
        this.errorMessage = error.error.error;
        sub.unsubscribe();
      }
    });
  }
}






