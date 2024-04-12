import { Component, OnInit } from '@angular/core';
import { UserService } from '../services/user.service'; // import des services (mehode) et model
import { User } from '../models/user.model';// un service a besoin de son model
import { Observable } from 'rxjs';


@Component({
  selector: 'app-gestion-utilisateur',
  templateUrl: './gestion-utilisateur.component.html',
  
  styleUrl: './gestion-utilisateur.component.css'
})
export class GestionUtilisateurComponent implements OnInit{

 selectedUser: User | null = null; // Stocke l'utilisateur sélectionné

  currentPage: number = 1;
  pageSize: number = 10;

  users!: Observable<User[]>;
  searchTerm: string = '';
  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
  //  this.users = this.userService.getUsers();
  this.users = this.userService.getUsers(this.currentPage, this.pageSize);
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

  searchUsers() {
    if (this.searchTerm.trim() !== '') {
      this.users = this.userService.searchUsersByName(this.searchTerm);
    } else {
      this.loadUsers(); 
    }
  }

  

  deleteUser(userId: number) {
    this.userService.deleteUser(userId).subscribe(() => {
      this.loadUsers(); // Recharger la liste des utilisateurs après suppression
    });
  }

  updateUser(user: User) {
    this.userService.updateUser(user); // Appeler la méthode de mise à jour de l'utilisateur
  }

  // Cette méthode doit être liée à un événement de formulaire pour ajouter un utilisateur
  addUser(user: User) {
    this.userService.addUser(user); // Appeler la méthode pour ajouter un utilisateur
  }

  selectUser(userId: number) {
    this.userService.getUserById(userId).subscribe(user => {
      console.log('Selected User:', user); // Vérifiez les données de l'utilisateur
      this.selectedUser = user; // Affecte l'utilisateur sélectionné
    });
  }



}
