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

  users!: Observable<User[]>;

  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.users = this.userService.getUsers() ;
  }

  deleteUser(id: number) {
    this.userService.deleteUser(id).subscribe(() => {
      this.users = this.userService.getUsers();
    });
  }

  updateUser(user: User){
  this.userService.updateUser(user);
  }

 addUser(user: User){
  this.userService.addUser ;
 }

}
