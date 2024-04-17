import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Image } from '../models/image.model';

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  
  private apiUrl = 'http://localhost/PROJET_ceREF/backend/image.php'; // URL de votre API pour les utilisateurs

  constructor(private http: HttpClient) { } 

  

  getImages(page: number, pageSize: number): Observable<Image[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}`;
    return this.http.get<Image[]>(url);
  }

   

   
  getImageById(imageId: number): Observable<Image> {
    return this.http.get<Image>( 'http://localhost/PROJET_ceREF/backend/image.php' + `?id=${imageId}`);
  }
  
 
  addImage(newImageId: Image): Observable<Image> {
    return this.http.post<Image>(this.apiUrl, newImageId);
  }



  searchImagesByName(page: number, pageSize: number, search: string): Observable<Image[]> {
    const url = `${this.apiUrl}?page=${page}&pageSize=${pageSize}&search=${search}`;
    return this.http.get<Image[]>(url);
  }


  updateImage(updatedImage: Image): Observable<Image> {
    const url = `${this.apiUrl}/${updatedImage.id_image}`;
    return this.http.put<Image>(url, updatedImage);
  }

  deleteImage(id: number): Observable<any> {
     return this.http.delete("http://localhost/PROJET_ceREF/backend/image.php?id=" + id);
  }









}