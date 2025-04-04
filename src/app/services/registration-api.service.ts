import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { User } from '../models/user.model';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RegistrationApiService {

  constructor(private http: HttpClient) { }
  private apiUrl = 'http://localhost/PROJET_ceREF/backend/registration.php';
  
 /* saveUser(user: User): Observable<User> {
    return this.http.post<User>("http://localhost/PROJET_ceREF/backend/registration.php", user);
  }*/

  saveUser(newUser: User): Observable<User> {
    return this.http.post<User>(this.apiUrl, newUser);
  }
}