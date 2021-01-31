select u.id, concat(u.first_name, ' ', u.last_name), b.author, group_concat(b.name)
from users u
inner join user_books ub on ub.user_id = u.id
inner join books b on b.id = ub.book_id
where u.age between 7 and 17
group by u.id, u.first_name, u.last_name, b.author
having count(ub.id) = 2
