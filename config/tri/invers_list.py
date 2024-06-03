nb = int(input())

l = [];

for i in range(nb):
    titre = input()
    l.append(titre)

l.sort()

for i in range(nb):
    print(l[i])