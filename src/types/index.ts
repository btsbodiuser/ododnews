export interface Category {
  id: number;
  name: string;
  name_en: string | null;
  slug: string;
  description: string | null;
  color: string;
  icon: string | null;
  sort_order: number;
  articles_count?: number;
  children?: Category[];
  parent?: Category;
}

export interface Author {
  id: number;
  name: string;
  slug: string;
  bio: string | null;
  avatar: string | null;
  position: string | null;
  social_links: Record<string, string> | null;
  articles_count?: number;
}

export interface Tag {
  id: number;
  name: string;
  slug: string;
}

export interface Article {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  body?: string;
  featured_image: string | null;
  featured_video: string | null;
  gallery: string[] | null;
  status: 'draft' | 'published' | 'archived';
  is_featured: boolean;
  is_breaking: boolean;
  is_trending: boolean;
  views_count: number;
  reading_time: number | null;
  published_at: string | null;
  published_at_human: string | null;
  source_name?: string | null;
  source_url?: string | null;
  seo_title?: string | null;
  seo_description?: string | null;
  category?: Category;
  author?: Author;
  tags?: Tag[];
  related?: Article[];
  meta?: Record<string, unknown>;
  created_at: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  links: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };
}

export interface User {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
}
