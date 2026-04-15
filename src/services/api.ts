import api from '@/lib/api';
import type { Article, Author, Category, PaginatedResponse, User } from '@/types';

// Articles
export const getArticles = (params?: Record<string, string | number>) =>
  api.get<PaginatedResponse<Article>>('/articles', { params }).then((r) => r.data);

export const getArticle = (slug: string) =>
  api.get<{ data: Article }>(`/articles/${slug}`).then((r) => r.data.data);

export const getFeaturedArticles = () =>
  api.get<{ data: Article[] }>('/articles/featured').then((r) => r.data.data);

export const getTrendingArticles = () =>
  api.get<{ data: Article[] }>('/articles/trending').then((r) => r.data.data);

export const getBreakingArticles = () =>
  api.get<{ data: Article[] }>('/articles/breaking').then((r) => r.data.data);

export const getLatestArticles = () =>
  api.get<{ data: Article[] }>('/articles/latest').then((r) => r.data.data);

export const searchArticles = (q: string, page = 1) =>
  api.get<PaginatedResponse<Article>>('/articles/search', { params: { q, page } }).then((r) => r.data);

export const getArticlesByCategory = (slug: string, page = 1) =>
  api.get<PaginatedResponse<Article>>(`/articles/category/${slug}`, { params: { page } }).then((r) => r.data);

// Categories
export const getCategories = () =>
  api.get<{ data: Category[] }>('/categories').then((r) => r.data.data);

export const getMenuCategories = () =>
  api.get<{ data: Category[] }>('/categories/menu').then((r) => r.data.data);

export const getCategory = (slug: string) =>
  api.get<{ data: Category }>(`/categories/${slug}`).then((r) => r.data.data);

// Authors
export const getAuthors = () =>
  api.get<{ data: Author[] }>('/authors').then((r) => r.data.data);

export const getAuthor = (slug: string) =>
  api.get<{ data: Author }>(`/authors/${slug}`).then((r) => r.data.data);

// Auth
export const login = (email: string, password: string) =>
  api.post<{ user: User; token: string }>('/auth/login', { email, password }).then((r) => r.data);

export const logout = () => api.post('/auth/logout');

export const getUser = () =>
  api.get<User>('/auth/user').then((r) => r.data);
