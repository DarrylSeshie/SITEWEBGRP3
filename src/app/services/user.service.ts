import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from '../models/user.model';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  private apiUrl = 'http://localhost/PROJET_ceREF/backend/user.php'; // URL de votre API pour les utilisateurs
  private apiUrl2 = 'http://localhost/PROJET_ceREF/backend/user2.php';

  constructor(private http: HttpClient) { } 

  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<number>(url);
  }


  getUsers(page: number, pageSize: number): Observable<User[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<User[]>(url);
  }

  
  getUserById(userId: number): Observable<User> {
    return this.http.get<User>( 'http://localhost/PROJET_ceREF/backend/user.php' + `?id=${userId}` );
  }

  addUser(newUserId: User): Observable<User> {
    return this.http.post<User>(this.apiUrl, newUserId);
  }
  


  searchUsersByName2(page: number, pageSize: number, search: string): Observable<User[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<User[]>(url);
  }


  
  updateUser(updatedUser: User): Observable<User> {
    const url = `${this.apiUrl}/${updatedUser.id_utilisateur}`;
    return this.http.put<User>(url, updatedUser);
  }

  
  updateRole(updatedUser: User): Observable<User> {
    const url = `${this.apiUrl2}/${updatedUser.id_utilisateur}`;
    return this.http.put<User>(url, updatedUser);
  }
  
  
  

  deleteUser(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/user.php?id=" + id);
   
  }


    // Méthode pour récupérer une adresse par son ID
    getAdresseById(adresseId: number): Observable<User> {
      return this.http.get<User>( 'http://localhost/PROJET_ceREF/backend/user.php' + `?id_adresse=${adresseId}` );
    }
  
    // Méthode pour récupérer un rôle par son ID
    getRoleById(roleId: number): Observable<User> {
      return this.http.get<User>( 'http://localhost/PROJET_ceREF/backend/role.php' + `?id=${roleId}` );
    }
  
    // Méthode pour récupérer une institution par son ID
    getInstitutionById(institutionId: number): Observable<any> {
      return this.http.get<User>( 'http://localhost/PROJET_ceREF/backend/user.php' + `?id_institution=${institutionId}` );
    }

    checkLogin(username: string, password: string): Observable<any> {
      return this.http.post("http://localhost/PROJET_ceREF/backend/user3.php", { username: username, password: password });
    }
  

  

  





}