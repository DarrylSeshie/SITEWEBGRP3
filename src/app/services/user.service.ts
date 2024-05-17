import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { User } from '../models/user.model';
import { CookieService } from 'ngx-cookie-service';
import { jwtDecode } from "jwt-decode";
import { tap } from 'rxjs/operators';
//import jwtDecode from 'jwt-decode';
import { BehaviorSubject } from 'rxjs';
import { Observable, throwError } from 'rxjs';
import { catchError,map  } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class UserService {
  private loggedIn = new BehaviorSubject<boolean>(false);
  get isLoggedIn() {
    return this.loggedIn.asObservable(); // Renvoie un observable pour réagir aux changements
  }

  setLoggedIn(value: boolean) {
    this.loggedIn.next(value); // Met à jour l'état de connexion
  }

  private apiUrl = 'http://localhost/PROJET_ceREF/backend/user.php'; // URL de votre API pour les utilisateurs
  private apiUrl2 = 'http://localhost/PROJET_ceREF/backend/user2.php';
  private apiUrl3 = 'http://localhost/PROJET_ceREF/backend/user3.php';
  private apiUrlJwt = 'http://localhost/PROJET_ceREF/backend/jwt_utils.php' ;

  constructor(private http: HttpClient , private cookieService: CookieService) { } 

  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<number>(url);
  }


  getUsers(page: number, pageSize: number): Observable<User[]> {
    const token = this.cookieService.get("token");
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<User[]>(url);
    
  }
 
  getUserById(userId: number): Observable<User> {
    return this.http.get<User>(`http://localhost/PROJET_ceREF/backend/user.php?id=${userId}`);
  }


  getUserByEmail(userEmail: string): Observable<User> {
    return this.http.get<User>(`${this.apiUrl3}?email=${userEmail}` )
      .pipe(
        catchError(this.handleError)
      );
  }

  

  addUser(newUserId: User): Observable<User> {
    return this.http.post<User>(this.apiUrl, newUserId);
  }
  


  searchUsersByName2(page: number, pageSize: number, search: string): Observable<User[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<User[]>(url);
  }


  updateUser(updatedUser: User): Observable<User> {
    const headers = this.getHeaders();
    const url = `${this.apiUrl}/${updatedUser.id_utilisateur}`;
    return this.http.put<User>(url, updatedUser);
  }

  
  updateRole(updatedUser: User): Observable<User> {
    const url = `${this.apiUrl2}/${updatedUser.id_utilisateur}`;
    return this.http.put<User>(url, updatedUser);
  }
  
  
  deleteUser(id: number): Observable<any> {
    return this.http.delete(`http://localhost/PROJET_ceREF/backend/user.php?id=${id}`);
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
      return this.http.post<{ access_token: string }>(this.apiUrl3, { username, password })
        .pipe(
          tap(response => {
            if (response && response.access_token) {
              this.cookieService.set("token", response.access_token);
            } else {
              console.error("No token received");
            }
          }),
          catchError(this.handleError)
        );
    }
  
    protected getHeaders(): HttpHeaders {
      const token = this.cookieService.get("token");
      if (!token) {
        // Gérer le cas où il n'y a pas de token
        console.error("No token available");
        return new HttpHeaders();  // Retourne des headers vides ou avec un contenu minimal
      }
      return new HttpHeaders({
        'Authorization': `Bearer ${token}`
      });
    }
  
  
    logout() {
      this.loggedIn.next(false); // Réinitialise l'état de connexion à false
    }


    validateJwt(token: string): Observable<any> {
      const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
      return this.http.get<any>(`${this.apiUrlJwt}`, { headers })
        .pipe(
          map(response => jwtDecode(token)),
          catchError(this.handleError)
        );
    }

    private handleError(error: any) {
      console.error('An error occurred', error);
      return throwError(error.message || error);
    }



}