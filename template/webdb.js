let itemsList,
	map = new Map(),
	idsMap = new Map();

function initIdsMap() {
	itemsList.forEach(item => {
		let itemId = item.getAttribute('webdb-id');
		let webSid = item.getAttribute('s-sid');

		if (idsMap.has(webSid)) {
			let items = idsMap.get(webSid);
			items.push(itemId);
		} else {
			let items = [itemId];
			idsMap.set(webSid, items);
		}
	});
}

let webDbFullLink,
	webDbLink = '';

window.addEventListener('DOMContentLoaded', _ => {
	if (document.querySelector('#webdb-link')) {

		webDbFullLink = document.querySelector('#webdb-link').getAttribute('src');

		if (webDbFullLink.startsWith('http')) {
			let l = webDbFullLink.split('/');
			webDbLink = l[0] + '//' + l[2];
		} else {
			webDbLink = '';
		}

		if (document.querySelector('.webdb-item')) {
			updateItems();
		} else {
			console.log('[WebDB System] No one item on current page.');
		}
	}
});

function updateItems() {
	itemsList = document.querySelectorAll('.webdb-item');
	initIdsMap();
	let promises = [];
	idsMap.forEach((value, key) => {
		promises.push(getItemsList(getIdParams(value), key));
	});
	Promise.all(promises)
		.then(() => {
			buildItems(map);

		});
}

function clearItems() {
	itemsList.forEach(i => {
		i.textContent = '';
	});
}

function buildItems(map) {
	clearItems();
	for (let div of itemsList) {
		let serverId = div.getAttribute('s-sid');
		let itemId = div.getAttribute('webdb-id');
		let options = {
			name: div.getAttribute('s-name') === "true",
			addName: div.getAttribute('s-add') === "true",
			icon: div.getAttribute('s-icon') === "true",
			descr: div.getAttribute('s-descr') === "true"
		};

		if (map.has(serverId)) {
			let items = map.get(serverId);
			let item = items.find(i => i.id === +itemId);

			if (item) {
				let nameSpan = document.createElement('span');
				if (options.icon) {
					if (checkValidationIcon(item.icon)) {
						let img = document.createElement('img');
						img.classList.add('webdb-icon');
						img.src = item.icon;
						div.appendChild(img);
					}
				}

				if (options.name) {
					nameSpan.innerHTML = `${item.name}`;
					nameSpan.classList.add('webdb-name');
					div.appendChild(nameSpan);
				}

				if (options.addName && item.add_name) {
					let addText = document.createElement('span');
					addText.classList.add('webdb-add');
					addText.innerHTML = `[${item.add_name}]`;
					nameSpan.appendChild(addText);
				}

				if (options.descr) {
					div.setAttribute('title', item.description);
				}
			} else {
				div.innerHTML = `<span class="s-error">There is NO ITEM with the specified ID:</span> &nbsp; <span class="s-error__id"> ${itemId}</span>  `;
				console.log(`В мапе такой хуйни нет [Server ID: ${serverId}, Item ID: ${itemId}]`);
			}
		}
	}
}

function checkValidationIcon(src) {
	if (src && src != webDbLink+'/template/panel/assets/media/icon/no_icon.png') {
		return true;
	} else {
		return false;
	}
}

function getIdParams(ids) {
	return ids.join();
}

function getItemsList(id, sid) {
	return new Promise((resolve, reject) => {
		fetch(webDbLink+'/api/item?sid='+sid+'&id='+id)
			.then(res => res.json())
			.then(res => {
				if (res.error) {
					throw new Error(res.error + '. With code: ' + res.code);
				} else {
					map.set(sid, res);
					resolve(res);
				}
			}).catch(err => {
				console.error(err);
			});
	});
}
