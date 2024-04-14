import { Component, OnInit } from '@angular/core';
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';
import { FormateurService } from '../services/formateur.service';

@Component({
  selector: 'app-gestion-formateur',
  templateUrl: './gestion-formateur.component.html',
  styleUrl: './gestion-formateur.component.css'
})
export class GestionFormateurComponent {


  
  selectedUser!: User; // Stocke l'utilisateur sélectionné
  currentPage: number = 1;
  pageSize: number = 10;
  formateurs!: Observable<User[]>;
  formateurs2!: Observable<User[]>;
  searchTerm: string = '';
  showSearchResults: boolean = false; 
  userDetailVisible: { [key: number]: boolean } = {};


  constructor(private formateurService: FormateurService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
  //  this.users = this.formateurService.getUsers();
  this.formateurs = this.formateurService.getUsers(this.currentPage, this.pageSize);
  this.showSearchResults = false;
  }

  
  nextPage() {
    this.currentPage++;
    console.log('Current Page:', this.currentPage);
    this.loadUsers();
  }
  
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('Current Page:', this.currentPage);
      this.loadUsers();
    }
  }

  toggleDetails(user: User) {
    const userId = user.id_utilisateur;
    if (this.userDetailVisible[userId]) {
      this.userDetailVisible[userId] = false;
    } else {
      this.userDetailVisible[userId] = true;
    }
  }

  searchUsersByname(searchTerm: string): void {
    if (this.searchTerm.trim() !== '') {
      // Charge les utilisateurs avec la recherche par nom et pagination
      this. formateurs2 = this.formateurService.searchFormateursByName2(this.currentPage, this.pageSize, searchTerm);
      this.showSearchResults = true; // Active le drapeau des résultats de recherche
    } else {
      // Charge à nouveau tous les utilisateurs si aucun terme de recherche n'est spécifié
      this.loadUsers();
    }
  }
  

  deleteUser(userId: number) {
    this.formateurService.deleteFormateur(userId).subscribe(() => {
      this.loadUsers(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateUser(user: User) {
    this.formateurService.updateFormateur(user); // Appeler la méthode de mise à jour de l'utilisateur
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addUser(user: User) {
    this.formateurService.addFormateur(user); // Appeler la méthode pour ajouter un utilisateur
  }

  selectUser(userId: number) {
    this.formateurService.getFormateurById(userId).subscribe(
      user => {
        this.selectedUser = user;
        // Toggle the visibility of user details
        this.toggleDetails(user);
      },
      error => {
        console.error('Error fetching user:', error);
      }
    );
  }
}
