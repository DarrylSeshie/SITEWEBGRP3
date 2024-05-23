import { Adresse } from '../models/adresse.model';// un service a besoin de son model
import { Institution } from '../models/institution.model';
import { Role } from '../models/role.model';

export interface User {
  id_utilisateur: number;
  civilite: string;
  nom: string;
  prenom: string;
  email: string;
  mot_de_passe: string;
  gsm: string;
  TVA?: string;
  profession: string;
  gsm_pro?: string;
  email_pro?: string;
  id_role: number;
  id_institution?: number;
  id_adresse: number;
  adresse?: Adresse; // Type Adresse pour les détails d'adresse
  institution?: Institution; // Type Institution pour les détails de l'institution
  role?: Role; // Type Role pour les détails du rôle */
  giografie?: string;
}
