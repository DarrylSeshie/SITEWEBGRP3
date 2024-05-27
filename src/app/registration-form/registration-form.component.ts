import { Component, EventEmitter, Output } from '@angular/core';
import { User } from '../models/user.model';
import {  OnInit   } from '@angular/core';
import { RegistrationApiService } from '../services/registration-api.service';
import { UserService } from '../services/user.service';
import { Router } from '@angular/router';
import { InstitutionService } from '../services/institution.service';
import { Institution } from '../models/institution.model';
declare const bootstrap: any;
@Component({
  selector: 'app-registration-form',
  templateUrl: './registration-form.component.html',
  styleUrl: './registration-form.component.css'
})
export class RegistrationFormComponent implements OnInit {
  @Output() addUserEvent = new EventEmitter();
   // message de notifs
   successMessage: string = '';
   errorMessage: string = '';
   totalUsers!: number;

  userToAdd: User = {
   
    id_utilisateur: -1,
    civilite: '',
    nom: '',
    prenom: '',
    email: '',
    mot_de_passe: '',
    gsm: '',
    profession: '',
    id_role: 4,
    id_adresse: -1,
    id_institution: -1, 
    adresse: {
      id_adresse: -1,
      code_postal: 0,
      rue_numero: '',
      localite: '',
      pays: ''
    },
    email_pro: '',   
    gsm_pro: '',
    giografie: '',
    TVA: '',
    institution: {
      id_institution: -1,
      nom: '',
      logo: 'null',
      id_adresse: -1
      },
    role: undefined
  };
  institutions: Institution[] = [];



  constructor(private service: RegistrationApiService ,private userService: UserService,private router: Router, private institutionService: InstitutionService) { }
  ngOnInit(): void {
    this.loadCount();
    this.loadInstitutions();
  }
  loadInstitutions(): void {
    this.institutionService.getInstitutions(1, 10).subscribe(
      (institutions) => {
        this.institutions = institutions;
      },
      (error) => {
        console.error('Error fetching institutions:', error);
      }
    );
  }

  saveUser() {
    const sub = this.service.saveUser(this.userToAdd).subscribe({
      next: (user) => {
        this.totalUsers ++ ;
        this.addUserEvent.emit(user);
        sub.unsubscribe();
        this.router.navigate(['/']);
      },
      error: (error) => {
        this.errorMessage = error.error.error;
        sub.unsubscribe();
        console.log('add User Error : ',error);
        this.showErrorToast('Erreur lors de l\'inscription');
      }
    });
  }


  
loadCount() {
  this.userService.getTotalUsersCount().subscribe(
    total => {
      this.totalUsers = total;
    },
    error => {
      console.error('Error fetching total users count:', error);
    }
  );
}



  
  private showSuccessToast(message: string) {
    this.successMessage = message;
    const toastElement = document.getElementById('liveToastSucchho');
    console.log(toastElement);
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = '';
  }

  private showErrorToast(message: string) {
    const toastElement = document.getElementById('liveToastErrhho');
    const toastBootstrap = new bootstrap.Toast(toastElement);
    toastBootstrap.show();
    this.errorMessage = message;
    this.successMessage = '';
  }

}






