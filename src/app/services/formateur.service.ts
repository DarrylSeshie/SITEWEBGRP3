import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable,map } from 'rxjs';
import { Formateur } from '../models/formateur.model';

@Injectable({
  providedIn: 'root'
})
export class FormateurService {

  private apiUrl = 'http://localhost/PROJET_ceREF/backend/formateur.php'; // URL de votre API pour les utilisateurs
  private apiUrl2 = 'http://localhost/PROJET_ceREF/backend/user.php';

  constructor(private http: HttpClient) { } 

  /*getUsers(): Observable<User[]> {
    return this.http.get<User[]>("http://localhost/PROJET_ceREF/backend/user.php");
  }*/

  getUsers(page: number, pageSize: number): Observable<Formateur[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Formateur[]>(url);
  }
  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<{ total: number }>(url).pipe(
      map(response => response.total)
    );
  }

   
  getFormateurById(FormateurId: number): Observable<Formateur> {
    return this.http.get<Formateur>( 'http://localhost/PROJET_ceREF/backend/formateur.php' + `?id=${FormateurId}` );
  }
  
 
  addFormateur(newFormateur: Formateur): Observable<Formateur> {
    return this.http.post<Formateur>(this.apiUrl2, newFormateur);
  }



  searchFormateursByName2(page: number, pageSize: number, search: string): Observable<Formateur[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Formateur[]>(url);
  }


  updateFormateur(updatedFormateur: Formateur): Observable<Formateur> {
    const url = `${this.apiUrl2}/${updatedFormateur.id_utilisateur}`;
    return this.http.put<Formateur>(url, updatedFormateur);
  }

  deleteFormateur(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/formateur.php?id=" + id);
  }



  

  

  





}