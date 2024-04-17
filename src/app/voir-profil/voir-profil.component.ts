
import { Component, OnInit } from '@angular/core';
import { UserProfile } from '../models/voirProfile.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { FormateurService } from '../services/formateur.service';
import { UserService } from '../services/user.service';

@Component({
  selector: 'app-voir-profil',
  templateUrl: './voir-profil.component.html',
  styleUrl: './voir-profil.component.css'
})
export class VoirProfilComponent {

}
