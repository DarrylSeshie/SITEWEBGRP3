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
  id_adresse: number;
  id_institution?: number;
  adresse?: {
    code_postal: number;
    rue_numero: string;
    localite: string;
    pays: string;
  };
  institution?: {
    nom: string;
    logo: string;
    id_adresse: number;
  };
  role?: Role;
  giografie?: string;
}


