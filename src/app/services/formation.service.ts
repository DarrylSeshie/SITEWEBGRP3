import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Formation } from '../models/formation.model';

@Injectable({
  providedIn: 'root'
})
export class FormationService {

  
  private apiUrl = 'http://localhost/PROJET_ceREF/backend/formation.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getFormations(page: number, pageSize: number): Observable<Formation[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Formation[]>(url);
  }

   

   
  getFormationById(formationId: number): Observable<Formation> {
    return this.http.get<Formation>( 'http://localhost/PROJET_ceREF/backend/formation.php' + `?id=${formationId}`);
  }
  
 
  addFormation(newformationId: Formation): Observable<Formation> {
    return this.http.post<Formation>(this.apiUrl, newformationId);
  }



  searchFormationsByName(page: number, pageSize: number, search: string): Observable<Formation[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Formation[]>(url);
  }


  updateFormation(updatedformation: Formation): Observable<Formation> {
    const url = `${this.apiUrl}/${updatedformation.id_produit}`;
    return this.http.put<Formation>(url, updatedformation);
  }

  deleteFormation(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/formation.php?id=" + id);
  }









}