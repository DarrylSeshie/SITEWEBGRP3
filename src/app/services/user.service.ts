import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from '../models/user.model';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  private apiUrl = 'http://localhost/PROJET_ceREF/backend/user.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  /*getUsers(): Observable<User[]> {
    return this.http.get<User[]>("http://localhost/PROJET_ceREF/backend/user.php");
  }*/

  getUsers(page: number, pageSize: number): Observable<User[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<User[]>(url);
  }

   
  getUserById(userId: number): Observable<User> {
    return this.http.get<User>( 'http://localhost/PROJET_ceREF/backend/user.php' + `?id=${userId}` );
  }
  
  addUser(newUser: User): Observable<User> {
    return this.http.post<User>(this.apiUrl, newUser);
  }

  searchUsersByName2(page: number, pageSize: number, search: string): Observable<User[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<User[]>(url);
  }

  
  updateUser(updatedUser: User): Observable<User> {
    const url = `${this.apiUrl}/${updatedUser.id_utilisateur}`;
    return this.http.put<User>(url, updatedUser);
  }

  deleteUser(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/user.php?id=" + id);
   
  }



  

  

  





}