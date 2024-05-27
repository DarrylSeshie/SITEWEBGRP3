import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { Formation } from '../models/formation.model';

@Injectable({
  providedIn: 'root'
})
export class FormationService {
  private apiUrl = 'http://localhost/PROJET_ceREF/backend/formation.php'; // URL de votre API pour les formations
  private inscriptionUrl = 'http://localhost/PROJET_ceREF/backend/inscription.php'; // URL de votre API pour les inscriptions

  constructor(private http: HttpClient) { }

  getFormationById(formationId: number): Observable<Formation> {
    return this.http.get<Formation>(`${this.apiUrl}?id=${formationId}`);
  }

  addFormation(newFormation: Formation): Observable<Formation> {
    return this.http.post<Formation>(this.apiUrl, newFormation);
  }

  searchFormationsByName(page: number, pageSize: number, search: string): Observable<Formation[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Formation[]>(url);
  }

  updateFormation(updatedFormation: Formation): Observable<Formation> {
    const url = `${this.apiUrl}/${updatedFormation.id_produit}`;
    return this.http.put<Formation>(url, updatedFormation);
  }

  deleteFormation(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}?id=${id}`);
  }

  get3ProduitsAvenir(): Observable<Formation[]> {
    const url = `${this.apiUrl}?get3ProduitsByDate`;
    return this.http.get<Formation[]>(url);
  }

  getFormationsByUser(userId: number): Observable<Formation[]> {
    const url = `http://localhost/PROJET_ceREF/backend/participe.php?id_utilisateur=${userId}`;
    return this.http.get<Formation[]>(url);
  }

  getDonneFormationsByUser(userId: number): Observable<Formation[]> {
    const url = `http://localhost/PROJET_ceREF/backend/donne.php?id=${userId}`;
    return this.http.get<Formation[]>(url);
  }

  inscrireUtilisateur(formationId: number, userId: number): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    const body = JSON.stringify({
      id_produit: formationId,
      id_utilisateur: userId
    });
    return this.http.post<any>(this.inscriptionUrl, body, { headers });
  }

  getFormations(page: number, pageSize: number): Observable<Formation[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Formation[]>(url);
  }

  deleteParticipant(id_utilisateur: number, id_produit: number): Observable<any> {
    const url = `http://localhost/PROJET_ceREF/backend/participe.php?id_utilisateur=${id_utilisateur}&id_produit=${id_produit}`;
    return this.http.delete(url);
  }

  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<{ total: number }>(url).pipe(
      map(response => response.total)
    );
  }

}