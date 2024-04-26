import { Adresse } from '../models/adresse.model';// un service a besoin de son model
export interface Institution {
    id_institution: number;        
    nom: string;
    logo: string;  
    id_adresse: number; 
    adresse?: Adresse; // Type Adresse pour les détails d'adresse            
  }