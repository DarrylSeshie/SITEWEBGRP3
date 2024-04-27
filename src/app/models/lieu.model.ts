import { Adresse } from '../models/adresse.model';// un service a besoin de son model
import { Institution } from '../models/institution.model';

export interface Lieu {
    id_lieu: number;        
    nom: string; 
    batiment: string;   
    locaux: string;
    id_institution :number;
    id_adresse :number;
    adresse?: Adresse; // Type Adresse pour les détails d'adresse
    institution?: Institution; 
  }