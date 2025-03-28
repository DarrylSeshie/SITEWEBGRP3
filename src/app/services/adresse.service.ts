import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable,map } from 'rxjs';
import { Adresse } from '../models/adresse.model';

@Injectable({
  providedIn: 'root'
})
export class AdresseService {


  private apiUrl = 'http://localhost/PROJET_ceREF/backend/adresse.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getAdresses(page: number, pageSize: number): Observable<Adresse[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Adresse[]>(url);
  }

  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<{ total: number }>(url).pipe(
      map(response => response.total)
    );
  }

   
  getAdresseById(adresseId: number): Observable<Adresse> {
    return this.http.get<Adresse>( 'http://localhost/PROJET_ceREF/backend/adresse.php' + `?id=${adresseId}`);
  }
  
 
  addAdresse(newAdresse: Adresse): Observable<Adresse> {
    return this.http.post<Adresse>(this.apiUrl, newAdresse);
  }



  searchAdressesByName2(page: number, pageSize: number, search: string): Observable<Adresse[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Adresse[]>(url);
  }


 
  updateAdresse(updateAdresse: Adresse): Observable<Adresse> {
    const url = `${this.apiUrl}/${updateAdresse.id_adresse}`;
    return this.http.put<Adresse>(url, updateAdresse);
  }

  deleteAdresse(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/adresse.php?id=" + id);
  }







}