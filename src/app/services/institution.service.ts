import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Institution } from '../models/institution.model';

@Injectable({
  providedIn: 'root'
})
export class InstitutionService {


  private apiUrl = 'http://localhost/PROJET_ceREF/backend/institution.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getInstitutions(page: number, pageSize: number): Observable<Institution[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Institution[]>(url);
  }

   

   
  getInstitutionById(adresseId: number): Observable<Institution> {
    return this.http.get<Institution>( 'http://localhost/PROJET_ceREF/backend/institution.php' + `?id=${adresseId}`);
  }
  
 
  addInstitution(newAdresse: Institution): Observable<Institution> {
    return this.http.post<Institution>(this.apiUrl, newAdresse);
  }



  searchInstitutionsByName(page: number, pageSize: number, search: string): Observable<Institution[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Institution[]>(url);
  }


  updateInstitution(updatedAdresse: Institution): Observable<Institution> {
    const url = `${this.apiUrl}/${updatedAdresse.id_adresse}`;
    return this.http.put<Institution>(url, updatedAdresse);
  }

  deleteInstitution(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/institution.php?id=" + id);
  }






}