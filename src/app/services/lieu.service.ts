import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable ,map} from 'rxjs';
import { Lieu } from '../models/lieu.model';

@Injectable({
  providedIn: 'root'
})
export class LieuService {


  private apiUrl = 'http://localhost/PROJET_ceREF/backend/lieu.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getLieux(page: number, pageSize: number): Observable<Lieu[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Lieu[]>(url);
  }
  getTotalUsersCount(): Observable<number> {
    const url = `${this.apiUrl}?count`;

    return this.http.get<{ total: number }>(url).pipe(
      map(response => response.total)
    );
  }

   
  getLieuById(LieuId: number): Observable<Lieu> {
    return this.http.get<Lieu>( 'http://localhost/PROJET_ceREF/backend/lieu.php' + `?id=${LieuId}` );
  }
  
 
  addLieu(newLieu: Lieu): Observable<Lieu> {
    return this.http.post<Lieu>(this.apiUrl, newLieu);
  }





  searchLieuxByName2(page: number, pageSize: number, search: string): Observable<Lieu[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Lieu[]>(url);
  }


  updateLieu(updateLieu: Lieu): Observable<Lieu> {
    const url = `${this.apiUrl}/${updateLieu.id_lieu}`;
    return this.http.put<Lieu>(url, updateLieu);
  }

  deleteLieu(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/lieu.php?id=" + id);
  }



}