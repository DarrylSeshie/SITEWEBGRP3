import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Institution } from '../models/institution.model';
import { map } from 'rxjs/operators';

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

   

   
  getInstitutionById(instId: number): Observable<Institution> {
    return this.http.get<Institution>( 'http://localhost/PROJET_ceREF/backend/institution.php' + `?id=${instId}`);
  }
  
 
  addInstitution(newInstitution: Institution): Observable<Institution> {
    return this.http.post<Institution>(this.apiUrl, newInstitution);
  }




  searchInstitutionsByName(page: number, pageSize: number, search: string): Observable<Institution[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Institution[]>(url);
  }


  updateInstitution(updatedInstitution: Institution): Observable<Institution> {
    const url = `${this.apiUrl}/${updatedInstitution.id_institution}`;
    return this.http.put<Institution>(url, updatedInstitution);
  }


  deleteInstitution(id: number): Observable<any> {
    return this.http.delete("http://localhost/PROJET_ceREF/backend/institution.php?id=" + id);
 }





}