# Workflow Git

## Quand je commence à travailler

```bash
git checkout dev
git pull origin dev
git checkout feature-tsiory
git merge dev
```

## Quand j'ai fini une fonctionnalité

```bash
git checkout dev
git pull origin dev
git merge feature-tsiory
git push origin dev
```

## Nettoyage de branche feature terminée

```bash
git branch -d feature-tsiory
git push origin --delete feature-tsiory
```

## Pour repartir sur une nouvelle branche

```bash
git checkout dev
git pull origin dev
git checkout -b feature-nouvelle-tache
```

## Message à prévenir sur WhatsApp

Fonctionnalite X terminee, mergee dans dev — faites git pull origin dev
