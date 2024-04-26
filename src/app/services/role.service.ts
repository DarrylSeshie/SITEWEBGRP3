import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Role } from '../models/role.model';


@Injectable({
    providedIn: 'root'
  })
  export class RoleService {
  
  
    private apiUrl = 'http://localhost/PROJET_ceREF/backend/role.php'; // URL de votre API pour les utilisateurs
  
    constructor(private http: HttpClient) { } 
  
    
    getRoleById(roleId: number): Observable<Role> {
        return this.http.get<Role>( 'http://localhost/PROJET_ceREF/backend/role.php' + `?id=${roleId}`);
      }
  
   
     
    /*updateRole(updatedRole: Role): Observable<Role> {
      const url = `${this.apiUrl}/${updatedRole.id_role}`;
      return this.http.put<Role>(url, updatedRole);
    }*/
  
  
  
  
  }