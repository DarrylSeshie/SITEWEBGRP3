import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { TypeProduit } from '../models/typeProduit.model';

@Injectable({
  providedIn: 'root'
})
export class TypeProduitService {

  
  private apiUrl = 'http://localhost/PROJET_ceREF/backend/typeProduit.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getTypeProduits(page: number, pageSize: number): Observable<TypeProduit[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<TypeProduit[]>(url);
  }

   

   
  getTypeProduitById(produitId: number): Observable<TypeProduit> {
    return this.http.get<TypeProduit>( 'http://localhost/PROJET_ceREF/backend/typeProduit.php' + `?id=${produitId}`);
  }
  
 
  addTypeProduit(newTypprodId: TypeProduit): Observable<TypeProduit> {
    return this.http.post<TypeProduit>(this.apiUrl, newTypprodId);
  }



  searchTypeProduitsByName(page: number, pageSize: number, search: string): Observable<TypeProduit[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<TypeProduit[]>(url);
  }


  updateTypeProduit(updatedTypeProduit: TypeProduit): Observable<TypeProduit> {
    const url = `${this.apiUrl}/${updatedTypeProduit.id_type_produit}`;
    return this.http.put<TypeProduit>(url, updatedTypeProduit);
  }

  deletetypeProduit(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/typeProduit.php?id=" + id);
  }









}