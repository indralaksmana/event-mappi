export default {
  ADD_SECTOR (state, sector) {
    state.sectors.unshift(sector)
  },
  SET_SECTORS (state, sectors) {
    state.sectors = sectors
  },
  UPDATE_SECTOR (state, sector) {
    const sectorIndex = state.sectors.findIndex((p) => p.id === sector.id)
    Object.assign(state.sectors[sectorIndex], sector)
  },
  REMOVE_SECTOR (state, sectorId) {
    const sectorIndex = state.sectors.findIndex((p) => p.id === sectorId)
    state.sectors.splice(sectorIndex, 1)
  },
  REMOVE_SECTORS (state, sectorIds) {
    sectorIds.map(sectorId => {
      const sectorIndex = state.sectors.findIndex((p) => p.id === sectorId)
      state.sectors.splice(sectorIndex, 1)
    })
  }
}
